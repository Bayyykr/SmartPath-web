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

function sosIcon(color) {
    return L.divIcon({
        className: "",
        html: `<span style="display:block;width:26px;height:26px;border-radius:999px;background:${color};border:4px solid rgba(255,255,255,.92);box-shadow:0 0 0 6px rgba(239,68,68,.22),0 2px 8px rgba(0,0,0,.35);"></span>`,
        iconSize: [26, 26],
        iconAnchor: [13, 13],
    });
}

function parseMapData() {
    const dataElement = document.getElementById("dashboard-map-data");
    if (!dataElement) return { points: [], areas: [] };

    try {
        const data = JSON.parse(dataElement.textContent || "{}");
        return {
            points: Array.isArray(data.points) ? data.points : [],
            areas: Array.isArray(data.areas) ? data.areas : [],
        };
    } catch (error) {
        console.error("Invalid dashboard map data", error);
        return { points: [], areas: [] };
    }
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

    const mapData = parseMapData();
    const boundsLayers = [];

    mapData.areas.forEach((area) => {
        const color = area.color || "#f97316";
        let layer = null;

        const fillOpacity = Number(area.opacity || 0.18);

        if (area.geojson) {
            layer = L.geoJSON(area.geojson, {
                style: {
                    color,
                    weight: 2,
                    fillColor: color,
                    fillOpacity,
                },
            }).addTo(map);
        } else if (area.lat && area.lng) {
            layer = L.circle([area.lat, area.lng], {
                radius: area.radius || 2500,
                color,
                weight: 2,
                fillColor: color,
                fillOpacity,
            }).addTo(map);
        }

        if (!layer) return;

        const difference = Number(area.difference || 0);
        const trendText =
            area.trend === "meningkat"
                ? `Meningkat +${difference}`
                : area.trend === "menurun"
                  ? `Menurun ${difference}`
                  : "Stabil";

        layer.bindPopup(`
            <strong>${area.name || "Area Rawan"}</strong><br>
            <small>Status: ${area.status || "Rawan"}</small><br>
            <small>Range: ${area.range || "-"}</small><br>
            <small>Bulan ini: ${area.total || 0} laporan</small><br>
            <small>Bulan lalu: ${area.previous_total || 0} laporan</small><br>
            <small>Tren: ${trendText}</small>
        `);

        boundsLayers.push(layer);
    });

    const points = mapData.points.filter((point) => point.lat && point.lng);

    points.forEach((point) => {
        const marker = L.marker([point.lat, point.lng], {
            icon:
                point.type === "sos"
                    ? sosIcon(point.color || "#ef4444")
                    : crimeIcon(point.color || "#248cc6"),
        }).addTo(map);

        marker.bindPopup(`
            <strong>${point.title || "Laporan"}</strong><br>
            <span>${point.subtitle || "-"}</span><br>
            <small>Status: ${(point.status || "-").replaceAll("_", " ")}</small>
        `);

        boundsLayers.push(marker);
    });

    if (boundsLayers.length > 0) {
        map.fitBounds(L.featureGroup(boundsLayers).getBounds(), {
            padding: [40, 40],
            maxZoom: 13,
        });
    }
});
