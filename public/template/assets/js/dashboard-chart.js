document.addEventListener("DOMContentLoaded", function () {
    const chartElement = document.getElementById("kategoriChart");

    if (!chartElement) return;

    const labels = JSON.parse(chartElement.dataset.labels);
    const values = JSON.parse(chartElement.dataset.values);

    new Chart(chartElement, {
        type: "bar",

        data: {
            labels: labels,

            datasets: [
                {
                    label: "Jumlah Produk",

                    data: values,

                    backgroundColor: [
                        "#1572E8",
                        "#31CE36",
                        "#F25961",
                        "#FFAD46",
                        "#6861CE",
                        "#48ABF7",
                        "#FDaf4B",
                    ],

                    borderRadius: 10,

                    borderWidth: 1,
                },
            ],
        },

        options: {
            responsive: true,

            plugins: {
                legend: {
                    display: true,
                },
            },

            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                    },
                },
            },
        },
    });
});
