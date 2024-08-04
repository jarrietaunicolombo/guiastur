const buques = {};
const recaladas = {};
const buquesWhitRecaladas = {};

class Buque {
    constructor(id, nombre) {
        this.id = id;
        this.nombre = nombre;
    }
}

class Recalada {
    constructor(
        recaladaId,
        buque,
        fechaArribo,
        fechaZarpe,
        paisId,
        paisNombre,
        observaciones = null,
        numeroAtenciones
    ) {
        this.recaladaId = recaladaId;
        this.buque = buque;
        this.fechaArribo = fechaArribo;
        this.fechaZarpe = fechaZarpe;
        this.paisId = paisId;
        this.paisNombre = paisNombre;
        this.observaciones = observaciones;
        this.numeroAtenciones = numeroAtenciones;
    }
}

function loadData(jsonData) {
    let recaladasJSon = jsonData.recaladas;
    if (typeof recaladasJSon === 'string') {
        recaladasJSon = JSON.parse(recaladasJSon); // Parsear si es una cadena
    }
    let buquesId = new Set();
    
    recaladasJSon.forEach(json => {  // corregido el nombre de la propiedad
        recaladaJson = "";
        if (typeof json === 'string') {
            recaladaJson = JSON.parse(json); // Parsear si es una cadena
        }
        const buque = new Buque(recaladaJson.buque_id, recaladaJson.buque_nombre);
        if (!buquesId.has(buque.id)) {
            buquesId.add(buque.id);
            buques[buque.id] = buque;  // corregido el uso de coma
            buquesWhitRecaladas[buque.id] = [];  // corregido el uso de coma
        }
        let recalada = new Recalada(
            recaladaJson.recaladaId,
            buque,
            new Date(recaladaJson.fecha_arribo.date),
            new Date(recaladaJson.fecha_zarpe.date),
            recaladaJson.pais_id,
            recaladaJson.pais_nombre,
            recaladaJson.observaciones,
            recaladaJson.numero_atenciones
        );
        recaladas[recalada.recaladaId] = recalada;  // corregido el uso de coma y propiedad correcta
        buquesWhitRecaladas[buque.id].push(recalada);
    });
    loadBuqueOptions();
}

function loadBuqueOptions(){
    let buqueSelect = document.getElementById('buque_id');
    for (let id in buques) {
            let option = document.createElement('option');
            option.value = id;
            option.text = buques[id].nombre;
            buqueSelect.add(option);
    }
}

document.getElementById('buque_id').addEventListener('change', function(event) {
    const buqueId = event.target.value;
    showInfoBuque(buques[buqueId]);
    loadRecaladaOptions(buqueId);
});


function loadRecaladaOptions(buqueId) {
    let recaladaSelect = document.getElementById('recalada_id');
    recaladaSelect.innerHTML = '<option value="" disabled selected>Seleccione una...</option>'; // Limpiar opciones anteriores
    
    // Verificar si hay recaladas para el buque seleccionado
    if (buquesWhitRecaladas[buqueId]) {
        buquesWhitRecaladas[buqueId].forEach(recalada => {
            let option = document.createElement('option');
            option.value = recalada.recaladaId;
            option.text = `ID: ${recalada.recaladaId} - ${recalada.fechaArribo.toLocaleString()} a ${recalada.fechaZarpe.toLocaleString()}`;
            recaladaSelect.add(option);
        });
    }
}

document.getElementById('recalada_id').addEventListener('change', function(event) {
    const recalda_id = event.target.value;
    showInfoRecalada(recaladas[recalda_id]);
});

function showInfoBuque(buque){
    let buqueName = document.getElementById('buque');
    buqueName.innerHTML = buque.nombre;
    let id = document.getElementById('recalada');
    let arribo = document.getElementById('arribo');
    let zarpe = document.getElementById('zarpe');
    id.innerHTML = "";
    arribo.innerHTML = "";
    zarpe.innerHTML = "";
}


function showInfoRecalada(recalada){
    let id = document.getElementById('recalada');
    let arribo = document.getElementById('arribo');
    let zarpe = document.getElementById('zarpe');
    id.innerHTML = recalada.recaladaId;
    arribo.innerHTML = recalada.fechaArribo.toLocaleString();
    zarpe.innerHTML = recalada.fechaZarpe.toLocaleString();
}
