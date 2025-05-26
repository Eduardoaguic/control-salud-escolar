document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formIndicador');
    if (form) {
      form.addEventListener('submit', (e) => {
        e.preventDefault();
        const peso = parseFloat(document.getElementById('peso').value);
        const talla = parseFloat(document.getElementById('talla').value);
        const hemoglobina = parseFloat(document.getElementById('hemoglobina').value);
  
        const imc = peso / (talla * talla);
        let alerta = '';
  
        if (imc < 18) alerta += 'IMC bajo. ';
        if (hemoglobina < 11) alerta += 'Riesgo de anemia.';
  
        document.getElementById('resultado').textContent = `IMC calculado: ${imc.toFixed(2)}. ${alerta}`;
  
        // Aquí se podría agregar una llamada a backend con fetch()
      });
    }
  });
  
  function mostrarSeccion(id) {
    document.querySelectorAll('.seccion').forEach(sec => sec.classList.remove('visible'));
    document.getElementById(id).classList.add('visible');
  }