// Simulación de datos para los gráficos (reemplaza con consulta dinámica si deseas)
const datosAnemia = [30, 70]; // 30% afectados
const datosSobrepeso = [10, 90];
const datosMalnutricion = [20, 80];

const opciones = {
  type: 'doughnut',
  options: {
    responsive: false,
    plugins: {
      legend: { display: false }
    }
  }
};

new Chart(document.getElementById("grafAnemia"), {
  ...opciones,
  data: {
    labels: ['Con Anemia', 'Sanos'],
    datasets: [{ data: datosAnemia, backgroundColor: ['#e74c3c', '#ecf0f1'] }]
  }
});

new Chart(document.getElementById("grafSobrepeso"), {
  ...opciones,
  data: {
    labels: ['Sobrepeso', 'Normal'],
    datasets: [{ data: datosSobrepeso, backgroundColor: ['#f1c40f', '#ecf0f1'] }]
  }
});

new Chart(document.getElementById("grafMalnutricion"), {
  ...opciones,
  data: {
    labels: ['Malnutrición', 'Sanos'],
    datasets: [{ data: datosMalnutricion, backgroundColor: ['#8e44ad', '#ecf0f1'] }]
  }
});
