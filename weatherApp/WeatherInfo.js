
import React from "react";

const WeatherInfo = ({ weather }) => {
  if (!weather) return null;

  const { main, wind, weather: weatherData } = weather;

  return (
    <div className="card mt-4" style={{ width: "18rem" }}>
      <div className="card-body">
        <h5 className="card-title">{weatherData[0].description.toUpperCase()}</h5>
        <p className="card-text">
          <strong>Sıcaklık:</strong> {main.temp}°C<br />
          <strong>Nem:</strong> {main.humidity}%<br />
          <strong>Rüzgar Hızı:</strong> {wind.speed} m/s
        </p>
      </div>
    </div>
  );
};

export default WeatherInfo;
