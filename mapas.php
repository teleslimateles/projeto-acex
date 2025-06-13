<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Creche Mais Próxima pelo CEP</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
  <style>
    #map {
      height: 500px;
      width: 100%;
      margin-top: 10px;
    }
    #cepForm {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <h2>Digite o CEP e veja a creche mais próxima</h2>
  <form id="cepForm">
    <label for="cep">CEP:</label>
    <input type="text" id="cep" name="cep" maxlength="8" required />
    <button type="submit">Buscar</button>
  </form>

  <div id="map"></div>

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
      const R = 6371; // Raio da Terra em km
      const dLat = (lat2 - lat1) * Math.PI / 180;
      const dLon = (lon2 - lon1) * Math.PI / 180;
      const a = 
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
      const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      return R * c;
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

        // Encontra a creche mais próxima
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
          .bindPopup(`<b>Creche mais próxima:</b><br>${crecheMaisProxima.nome}<br><a href="detalhes.html?nome=${encodeURIComponent(crecheMaisProxima.nome)}">Ver detalhes</a>`);


      } catch (err) {
        alert(err.message);
      }
    });
  </script>
</body>
</html>
