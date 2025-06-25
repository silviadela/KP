// 🕒 JAM REAL-TIME
function updateJam() {
    const el = document.getElementById('clock');
    const now = new Date();
    const jam = now.getHours().toString().padStart(2, '0');
    const menit = now.getMinutes().toString().padStart(2, '0');
    const detik = now.getSeconds().toString().padStart(2, '0');
    el.innerText = `🕒 ${jam}:${menit}:${detik}`;
}
setInterval(updateJam, 1000);
updateJam();

// 📈 INISIALISASI CHART SUHU
const tempCtx = document.getElementById("tempChart").getContext("2d");
const tempChart = new Chart(tempCtx, {
    type: "line",
    data: {
        labels: [],
        datasets: [{
            label: "Suhu (°C)",
            data: [],
            borderColor: "orange",
            backgroundColor: "rgba(255,165,0,0.3)",
            fill: true,
            tension: 0.3,
            pointRadius: 2
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: false } }
    }
});

// 📉 INISIALISASI CHART KELEMBAPAN
const humidCtx = document.getElementById("humidChart").getContext("2d");
const humidChart = new Chart(humidCtx, {
    type: "line",
    data: {
        labels: [],
        datasets: [{
            label: "Kelembapan (%)",
            data: [],
            borderColor: "blue",
            backgroundColor: "rgba(0,0,255,0.2)",
            fill: true,
            tension: 0.3,
            pointRadius: 2
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: false } }
    }
});

// 🔄 UPDATE DATA OTOMATIS
function fetchDataAndUpdate() {
    fetch('/api/data-thingspeak')
        .then(res => res.json())
        .then(data => {
            const labels = data.map(d => d.created_at.slice(11, 16));
            const suhu = data.map(d => parseFloat(d.field2));
            const kelembapan = data.map(d => parseFloat(d.field3));

            tempChart.data.labels = labels;
            tempChart.data.datasets[0].data = suhu;
            tempChart.update();

            humidChart.data.labels = labels;
            humidChart.data.datasets[0].data = kelembapan;
            humidChart.update();

            document.getElementById("jumlah-data").innerText = data.length;

            const tbody = document.querySelector("table tbody");
            tbody.innerHTML = "";
            data.slice().reverse().forEach(item => {
                tbody.innerHTML += `
                    <tr>
                        <td>${item.created_at}</td>
                        <td>${item.field2 !== null ? item.field2 : 'null'}</td>
                        <td>${item.field3 !== null ? item.field3 : 'null'}</td>
                    </tr>
                `;
            });
        })
        .catch(err => {
            console.error("Gagal mengambil data:", err);
        });
}

// 🔁 Update pertama kali dan tiap 20 detik
fetchDataAndUpdate();
setInterval(fetchDataAndUpdate, 20000);
