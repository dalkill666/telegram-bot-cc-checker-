const { exec } = require("child_process");
const path = require('path');

// Función para procesar los datos de la tarjeta usando PHP

function processCardData(cc, mes, ano, cvv) {
  return new Promise((resolve, reject) => {
    const phpPath = path.join(__dirname, 'function_mass1.php');
    const command = `php "${phpPath}" ${cc} ${mes} ${ano} ${cvv}`;

    exec(command, (error, stdout, stderr) => {
      if (error) {
        reject(`Error: ${stderr}`);
      } else {
        resolve(`${stdout}`);
      }
    });
  });
}

async function runProcesses(cardDataList) {
  const promises = cardDataList.map((card) =>
    processCardData(card.cc, card.mes, card.ano, card.cvv)
  );

  try {
    const results = await Promise.all(promises);
    results.forEach((result) => console.log(result));
  } catch (error) {
    console.error(error);
  }
}

// Obtener los datos desde los argumentos de línea de comandos
const args = process.argv.slice(2).join(" ");
const cardDataArray = args.split(";").map((item) => {
  const [cc, mes, ano, cvv] = item.split("|");
  return { cc, mes, ano, cvv };
});

runProcesses(cardDataArray);