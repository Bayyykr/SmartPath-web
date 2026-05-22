import Chart from "chart.js/auto";

const percentLabelPlugin = {
    id: "percentLabelPlugin",
    afterDatasetsDraw(chart) {
        if (chart.config.type !== "pie") return;

        const { ctx } = chart;
        const meta = chart.getDatasetMeta(0);
        const data = chart.data.datasets[0].data;

        ctx.save();
        ctx.fillStyle = "#ffffff";
        ctx.font = "9px Figtree, sans-serif";
        ctx.textAlign = "center";
        ctx.textBaseline = "middle";

        meta.data.forEach((arc, index) => {
            const value = data[index];
            const { x, y } = arc.tooltipPosition();
            ctx.fillText(`${value}%`, x, y);
        });

        ctx.restore();
    },
};

Chart.register(percentLabelPlugin);

function baseOptions() {
    return {
        responsive: true,
        maintainAspectRatio: false,
        animation: false,
        plugins: {
            legend: {
                position: "bottom",
                labels: {
                    boxWidth: 7,
                    boxHeight: 7,
                    padding: 8,
                    font: { size: 9 },
                    color: "#111827",
                },
            },
            tooltip: { enabled: true },
        },
    };
}

function initializeInfografikCharts() {
    const dataElement = document.getElementById("infografik-chart-data");
    if (!dataElement) return;

    const chartData = JSON.parse(dataElement.textContent || "{}");
    const statistikCanvas = document.getElementById("infografikStatistikChart");
    const kecamatanCanvas = document.getElementById("infografikKecamatanChart");
    const kategoriCanvas = document.getElementById("infografikKategoriChart");
    const maxMonthlyValue = Math.max(
        ...(chartData.monthly?.kejahatan || [0]),
        ...(chartData.monthly?.kecelakaan || [0]),
        2,
    );
    const maxLocationValue = Math.max(
        ...(chartData.locations?.kejahatan || [0]),
        ...(chartData.locations?.kecelakaan || [0]),
        1,
    );
    const maxCategoryValue = Math.max(
        ...(chartData.categories?.totals || [0]),
        1,
    );

    if (statistikCanvas) {
        new Chart(statistikCanvas, {
            type: "line",
            data: {
                labels: chartData.monthly?.labels || [],
                datasets: [
                    {
                        label: "Kejahatan",
                        data: chartData.monthly?.kejahatan || [],
                        borderColor: "#248cc6",
                        backgroundColor: "#248cc6",
                        borderWidth: 4,
                        pointRadius: 0,
                        pointHoverRadius: 3,
                        tension: 0,
                    },
                    {
                        label: "Kecelakaan",
                        data: chartData.monthly?.kecelakaan || [],
                        borderColor: "#45b8a9",
                        backgroundColor: "#45b8a9",
                        borderWidth: 4,
                        pointRadius: 0,
                        pointHoverRadius: 3,
                        tension: 0,
                    },
                ],
            },
            options: {
                ...baseOptions(),
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: "#111827", font: { size: 11 } },
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: Math.max(2, maxMonthlyValue),
                        ticks: {
                            stepSize: 0.2,
                            color: "#111827",
                            font: { size: 10 },
                        },
                        grid: { color: "#d1d5db" },
                    },
                },
            },
        });
    }

    if (kecamatanCanvas) {
        new Chart(kecamatanCanvas, {
            type: "bar",
            data: {
                labels: chartData.locations?.labels || [],
                datasets: [
                    {
                        label: "Kejahatan",
                        data: chartData.locations?.kejahatan || [],
                        backgroundColor: "#248cc6",
                        borderWidth: 0,
                        barThickness: 5,
                    },
                    {
                        label: "Kecelakaan",
                        data: chartData.locations?.kecelakaan || [],
                        backgroundColor: "#45b8a9",
                        borderWidth: 0,
                        barThickness: 5,
                    },
                ],
            },
            options: {
                ...baseOptions(),
                indexAxis: "y",
                scales: {
                    x: {
                        beginAtZero: true,
                        suggestedMax: Math.max(1, maxLocationValue),
                        ticks: {
                            stepSize: 0.1,
                            color: "#111827",
                            font: { size: 10 },
                        },
                        grid: { color: "#d1d5db" },
                    },
                    y: {
                        grid: { color: "#e5e7eb" },
                        ticks: { color: "#111827", font: { size: 10 } },
                    },
                },
            },
        });
    }

    if (kategoriCanvas) {
        new Chart(kategoriCanvas, {
            type: "bar",
            data: {
                labels: chartData.categories?.labels || [],
                datasets: [
                    {
                        label: "Total Kasus",
                        data: chartData.categories?.totals || [],
                        backgroundColor:
                            chartData.categories?.colors || "#248cc6",
                        borderWidth: 0,
                        barThickness: 28,
                    },
                ],
            },
            options: {
                ...baseOptions(),
                plugins: {
                    ...baseOptions().plugins,
                    legend: { display: false },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: "#111827", font: { size: 10 } },
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMax: Math.max(1, maxCategoryValue),
                        ticks: {
                            stepSize: 0.5,
                            color: "#111827",
                            font: { size: 10 },
                        },
                        grid: { color: "#d1d5db" },
                    },
                },
            },
        });
    }
}

function initializeCharts() {
    initializeInfografikCharts();

    const statistikCanvas = document.getElementById("statistikChart");
    const laporanCanvas = document.getElementById("laporanChart");
    const pieCanvas = document.getElementById("kejahatanKecelakaanChart");

    if (statistikCanvas) {
        new Chart(statistikCanvas, {
            type: "line",
            data: {
                labels: ["Maret", "April", "Mei", "Juni"],
                datasets: [
                    {
                        label: "Kejahatan",
                        data: [0.5, 1, 1, 4.7],
                        borderColor: "#218cc6",
                        backgroundColor: "#218cc6",
                        borderWidth: 4,
                        pointRadius: 0,
                        tension: 0,
                    },
                    {
                        label: "Kecelakaan",
                        data: [0.4, 1.1, 2, 2],
                        borderColor: "#45b8a9",
                        backgroundColor: "#45b8a9",
                        borderWidth: 4,
                        pointRadius: 0,
                        tension: 0,
                    },
                ],
            },
            options: {
                ...baseOptions(),
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: "#111827", font: { size: 9 } },
                    },
                    y: {
                        min: 0,
                        max: 5,
                        ticks: {
                            stepSize: 0.5,
                            color: "#111827",
                            font: { size: 9 },
                        },
                        grid: { color: "#d1d5db" },
                    },
                },
            },
        });
    }

    if (laporanCanvas) {
        new Chart(laporanCanvas, {
            type: "bar",
            data: {
                labels: ["Lumajang", "Sumbersuko", "Kunir", "Yosowilangun"],
                datasets: [
                    {
                        label: "Kejahatan",
                        data: [1.5, 1.5, 1.5, 2],
                        backgroundColor: [
                            "#248cc6",
                            "#45b8a9",
                            "#45b8a9",
                            "#45b8a9",
                        ],
                        borderWidth: 0,
                        barThickness: 12,
                    },
                ],
            },
            options: {
                ...baseOptions(),
                indexAxis: "y",
                scales: {
                    x: {
                        min: 0,
                        max: 2,
                        ticks: {
                            stepSize: 0.5,
                            color: "#111827",
                            font: { size: 9 },
                        },
                        grid: { color: "#d1d5db" },
                    },
                    y: {
                        grid: { display: false },
                        ticks: { color: "#111827", font: { size: 10 } },
                    },
                },
                plugins: {
                    ...baseOptions().plugins,
                    legend: {
                        position: "bottom",
                        labels: {
                            boxWidth: 7,
                            boxHeight: 7,
                            padding: 8,
                            font: { size: 9 },
                            generateLabels() {
                                return [
                                    {
                                        text: "Kejahatan",
                                        fillStyle: "#248cc6",
                                        strokeStyle: "#248cc6",
                                    },
                                    {
                                        text: "Kecelakaan",
                                        fillStyle: "#45b8a9",
                                        strokeStyle: "#45b8a9",
                                    },
                                ];
                            },
                        },
                    },
                },
            },
        });
    }

    if (pieCanvas) {
        new Chart(pieCanvas, {
            type: "pie",
            data: {
                labels: [
                    "27.3%",
                    "18.2%",
                    "9.1%",
                    "9.1%",
                    "9.1%",
                    "5.1%",
                    "5.1%",
                    "17.0%",
                ],
                datasets: [
                    {
                        data: [27.3, 18.2, 9.1, 9.1, 9.1, 5.1, 5.1, 17.0],
                        backgroundColor: [
                            "#2693d1",
                            "#45b8a9",
                            "#f0c34f",
                            "#f28c38",
                            "#ef5b7d",
                            "#7c5cc4",
                            "#35a7d6",
                            "#62c66d",
                        ],
                        borderWidth: 1,
                        borderColor: "#ffffff",
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label(context) {
                                return `${context.parsed}%`;
                            },
                        },
                    },
                },
            },
        });
    }
}

window.addEventListener("DOMContentLoaded", initializeCharts);
