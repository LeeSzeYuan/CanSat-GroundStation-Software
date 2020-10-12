

async function getData() {
    const weathersDataResponse = await fetch('weather.json');  
    const weathersData = await weathersDataResponse.json();  
    const cleaned = weathersData.map(weather => ({
        humi: weather.Relative_Humidity,
        temp: weather.Temperature,
    }))
    .filter(weather => (weather.humi != null && weather.temp != null)); //I dont need this part
    
    return cleaned;
}

async function run() {
    // Load and plot the original input data that we are going to train on.
    const data = await getData();
    const values = data.map(d => ({
        x: d.humi,
        y: d.temp,
    }));

    tfvis.render.scatterplot(
        {name: 'Temp v humi'},
        {values}, 
        {
        xLabel: 'Humdity',
        yLabel: 'Temperature',
        height: 500
        }
    );

    // More code will be added below

    // Convert the data to a form we can use for training.
    const tensorData = convertToTensor(data);
    const {inputs, labels} = tensorData;
        
    // Train the model  
    await trainModel(model, inputs, labels);
    console.log('Done Training');

    // Make some predictions using the model and compare them to the
    // original data
    testModel(model, data, tensorData);
}

document.addEventListener('DOMContentLoaded', run);

function createModel() {
    // Create a sequential model
    const model = tf.sequential(); 
    
    // Add a single input layer
    model.add(tf.layers.dense({inputShape: [1], units: 1, useBias: true}));
    model.add(tf.layers.dense({units: 50, activation: 'sigmoid'}));
    // Add an output layer
    model.add(tf.layers.dense({units: 1, useBias: true}));

    return model;
}

// Create the model
const model = createModel();  
tfvis.show.modelSummary({name: 'Model Summary'}, model);

function convertToTensor(data) {
    // Wrapping these calculations in a tidy will dispose any 
    // intermediate tensors.
    
    return tf.tidy(() => {
      // Step 1. Shuffle the data    
    tf.util.shuffle(data);

    // Step 2. Convert data to Tensor
    const inputs = data.map(d => d.humi)
    const labels = data.map(d => d.temp);

    const inputTensor = tf.tensor2d(inputs, [inputs.length, 1]);
    const labelTensor = tf.tensor2d(labels, [labels.length, 1]);

    //Step 3. Normalize the data to the range 0 - 1 using min-max scaling
    const inputMax = inputTensor.max();
    const inputMin = inputTensor.min();  
    const labelMax = labelTensor.max();
    const labelMin = labelTensor.min();

    const normalizedInputs = inputTensor.sub(inputMin).div(inputMax.sub(inputMin));
    const normalizedLabels = labelTensor.sub(labelMin).div(labelMax.sub(labelMin));

    return {
    inputs: normalizedInputs,
    labels: normalizedLabels,
    // Return the min/max bounds so we can use them later.
    inputMax,
    inputMin,
    labelMax,
    labelMin,
    }
});  
}

async function trainModel(model, inputs, labels) {
    // Prepare the model for training.  
    model.compile({
        optimizer: tf.train.adam(),
        loss: tf.losses.meanSquaredError,
        metrics: ['mse'],
    });

    const batchSize = 32;
    const epochs = 50;

    return await model.fit(inputs, labels, {
        batchSize,
        epochs,
        shuffle: true,
        callbacks: tfvis.show.fitCallbacks(
        { name: 'Training Performance' },
        ['loss', 'mse'], 
        { height: 200, callbacks: ['onEpochEnd'] }
        )
    });
}

function testModel(model, inputData, normalizationData) {
    const {inputMax, inputMin, labelMin, labelMax} = normalizationData;  
    
    // Generate predictions for a uniform range of numbers between 0 and 1;
    // We un-normalize the data by doing the inverse of the min-max scaling 
    // that we did earlier.
    const [xs, preds] = tf.tidy(() => {
    
        const xs = tf.linspace(0, 1, 100);      
        const preds = model.predict(xs.reshape([100, 1]));      
        
        const unNormXs = xs
        .mul(inputMax.sub(inputMin))
        .add(inputMin);
        
        const unNormPreds = preds
        .mul(labelMax.sub(labelMin))
        .add(labelMin);
        
        // Un-normalize the data
        return [unNormXs.dataSync(), unNormPreds.dataSync()];
    });


    const predictedPoints = Array.from(xs).map((val, i) => {
        return {x: val, y: preds[i]}
    });

    const originalPoints = inputData.map(d => ({
        x: d.humi, y: d.temp,
    }));


    tfvis.render.scatterplot(
        {name: 'Model Predictions vs Original Data'}, 
        {values: [originalPoints, predictedPoints], series: ['original', 'predicted']}, 
        {
        xLabel: 'Humidity',
        yLabel: 'Temperature',
        height: 500
        }
    );
}