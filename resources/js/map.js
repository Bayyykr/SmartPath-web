import L from "leaflet";
import "leaflet/dist/leaflet.css";

function crimeIcon(color) {
    return L.divIcon({
        className: "",
        html: `<span style="display:block;width:22px;height:22px;border-radius:999px;background:${color};border:4px solid rgba(255,255,255,.85);box-shadow:0 1px 4px rgba(0,0,0,.35);"></span>`,
        iconSize: [22, 22],
        iconAnchor: [11, 11],
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const mapElement = document.getElementById("map");
    if (!mapElement) return;

    const map = L.map("map", {
        zoomControl: true,
        attributionControl: true,
    }).setView([-8.1322, 113.2245], 12);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "&copy; OpenStreetMap",
    }).addTo(map);

    const points = [
        [-8.1267, 113.2209, "#d3306f"],
        [-8.1315, 113.224, "#d3306f"],
        [-8.1387, 113.2228, "#d3306f"],
        [-8.1289, 113.2309, "#2f80c9"],
        [-8.15, 113.1902, "#42b883"],
    ];

    points.forEach(([lat, lng, color]) => {
        L.marker([lat, lng], { icon: crimeIcon(color) }).addTo(map);
    });
});
