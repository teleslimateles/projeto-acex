<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Creche Mais Próxima pelo CEP</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonte moderna -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Leaflet -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />

  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: "Poppins", sans-serif;
      background: #f4f6f8;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      align-items: center;
      color: #333;
      position: relative;
      overflow-x: hidden;
    }

    /* LATERAIS AZUIS MINIMALISTAS */
    body::before, body::after {
      content: "";
      position: fixed;
      top: 0;
      width: 100px;
      height: 100%;
      background: linear-gradient(180deg, rgba(0,120,255,0.12), rgba(0,120,255,0.05));
      z-index: -1;
    }
    body::before {
      left: 0;
      clip-path: polygon(0 0, 100% 0, 70% 100%, 0% 100%);
      border-right: 1px solid rgba(0,120,255,0.15);
    }
    body::after {
      right: 0;
      clip-path: polygon(30% 0, 100% 0, 100% 100%, 0% 100%);
      border-left: 1px solid rgba(0,120,255,0.15);
    }

    /* Detalhes circulares sutis */
    .circle {
      position: fixed;
      border-radius: 50%;
      background: radial-gradient(circle at center, rgba(0,120,255,0.15) 0%, transparent 70%);
      z-index: -1;
      filter: blur(2px);
    }

    .circle.one {
      top: 20%;
      left: 3%;
      width: 150px;
      height: 150px;
    }
    .circle.two {
      bottom: 15%;
      right: 4%;
      width: 180px;
      height: 180px;
    }

    header {
      width: 100%;
      background: #fff;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      padding: 25px 15px;
      text-align: center;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    header h2 {
      margin: 0;
      font-weight: 600;
      font-size: 1.5rem;
      color: #0078ff;
    }

    form {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 10px;
      margin: 20px auto;
      background: #fff;
      padding: 15px 20px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      max-width: 600px;
    }

    label {
      font-weight: 500;
      align-self: center;
    }

    input[type="text"] {
      padding: 10px 12px;
      border: 1.5px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      width: 150px;
      transition: all 0.3s ease;
    }

    input[type="text"]:focus {
      border-color: #0078ff;
      outline: none;
      box-shadow: 0 0 0 3px rgba(0, 120, 255, 0.2);
    }

    button {
      background-color: #0078ff;
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: 0.3s ease;
    }

    button:hover {
      background-color: #005fcc;
    }

    #map {
      width: 95%;
      max-width: 1200px;
      height: 550px;
      border-radius: 15px;
      box-shadow: 0 3px 15px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      margin-bottom: 40px;
    }

    footer {
      font-size: 0.85rem;
      color: #777;
      padding: 20px;
      text-align: center;
    }

    @media (max-width: 600px) {
      form {
        flex-direction: column;
        align-items: stretch;
      }
      input[type="text"], button {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <!-- Detalhes de fundo -->
  <div class="circle one"></div>
  <div class="circle two"></div>

  <header>
    <h2>🔎 Digite o CEP e veja a creche mais próxima</h2>
  </header>

  <form id="cepForm">
    <label for="cep">CEP:</label>
    <input type="text" id="cep" name="cep" maxlength="8" required placeholder="Ex: 09010120" />
    <button type="submit">Buscar</button>
  </form>

  <div id="map"></div>

  <footer>© 2025 — Sistema de Localização de Creches | Desenvolvido com OpenStreetMap 💙</footer>

  <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
  <script>
    const map = L.map('map').setView([-23.6639, -46.5383], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let markerEndereco, markerCreche;

    async function buscarEnderecoPorCEP(cep) {
      const res = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
      if (!res.ok) throw new Error("Erro ao buscar o CEP.");
      const data = await res.json();
      if (data.erro) throw new Error("CEP não encontrado.");
      return {
        endereco: `${data.logradouro}, ${data.bairro}, Santo André, SP, Brasil`,
        logradouro: data.logradouro,
        bairro: data.bairro
      };
    }

    async function obterCoordenadas(endereco) {
      const url = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(endereco)}`;
      const res = await fetch(url);
      const data = await res.json();
      if (data.length === 0) throw new Error("Endereço não encontrado.");
      return { lat: parseFloat(data[0].lat), lon: parseFloat(data[0].lon) };
    }

    function calcularDistancia(lat1, lon1, lat2, lon2) {
      const R = 6371;
      const dLat = (lat2 - lat1) * Math.PI / 180;
      const dLon = (lon2 - lon1) * Math.PI / 180;
      const a =
        Math.sin(dLat / 2) ** 2 +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) ** 2;
      return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    async function buscarCrechesProximas(lat, lon) {
      const url = `https://nominatim.openstreetmap.org/search?format=json&q=creche&limit=5&bounded=1&viewbox=${lon - 0.01},${lat + 0.01},${lon + 0.01},${lat - 0.01}`;
      const res = await fetch(url);
      const data = await res.json();
      if (data.length === 0) throw new Error("Nenhuma creche encontrada.");
      return data.map(item => ({
        nome: item.display_name,
        lat: parseFloat(item.lat),
        lon: parseFloat(item.lon)
      }));
    }

    document.getElementById('cepForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const cep = document.getElementById('cep').value.trim();
      if (!/^\d{8}$/.test(cep)) {
        alert("CEP inválido. Digite 8 números.");
        return;
      }

      try {
        const { endereco } = await buscarEnderecoPorCEP(cep);
        const coords = await obterCoordenadas(endereco);

        if (markerEndereco) map.removeLayer(markerEndereco);
        markerEndereco = L.marker([coords.lat, coords.lon])
          .addTo(map)
          .bindPopup(`<b>Endereço:</b><br>${endereco}`)
          .openPopup();

        map.setView([coords.lat, coords.lon], 15);

        const creches = await buscarCrechesProximas(coords.lat, coords.lon);

        let crecheMaisProxima = creches[0];
        let menorDistancia = calcularDistancia(coords.lat, coords.lon, crecheMaisProxima.lat, crecheMaisProxima.lon);

        creches.forEach(creche => {
          const dist = calcularDistancia(coords.lat, coords.lon, creche.lat, creche.lon);
          if (dist < menorDistancia) {
            menorDistancia = dist;
            crecheMaisProxima = creche;
          }
        });

        if (markerCreche) map.removeLayer(markerCreche);
        markerCreche = L.marker([crecheMaisProxima.lat, crecheMaisProxima.lon], {
          icon: L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/1048/1048927.png',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            popupAnchor: [0, -30]
          })
        }).addTo(map)
          .bindPopup(`<b>Creche mais próxima:</b><br>${crecheMaisProxima.nome}<br><a href="detalhes.html?nome=${encodeURIComponent(crecheMaisProxima.nome)}" target="_blank">Ver detalhes</a>`);
      } catch (err) {
        alert(err.message);
      }
    });
  </script>
</body>
</html>
