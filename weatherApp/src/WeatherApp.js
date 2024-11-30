import React, { useState } from "react";
import axios from "axios";
import "bootstrap/dist/css/bootstrap.min.css";

const WeatherApp = () => {
  const [city, setCity] = useState("");
  const [weather, setWeather] = useState(null);

  const fetchWeather = async () => {
    try {
      const API_KEY = "YOUR_API_KEY";
      const response = await axios.get(
        `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=metric&appid=${API_KEY}`
      );
      setWeather(response.data);
    } catch (error) {
      alert("Şehir bulunamadı.");
    }
  };

  return (
    <div className="container text-center my-5">
      <h1>Hava Durumu Uygulaması</h1>
      <input
        type="text"
        placeholder="Şehir adı girin"
        value={city}
        onChange={(e) => setCity(e.target.value)}
        className="form-control my-3"
      />
      <button onClick={fetchWeather} className="btn btn-primary">
        Hava Durumunu Getir
      </button>
      {weather && (
        <div className="card mt-4">
          <div className="card-body">
            <h5 className="card-title">{weather.weather[0].description}</h5>
            <p className="card-text">
              <strong>Sıcaklık:</strong> {weather.main.temp}°C<br />
              <strong>Nem:</strong> {weather.main.humidity}%<br />
              <strong>Rüzgar:</strong> {weather.wind.speed} m/s
            </p>
          </div>
        </div>
      )}
    </div>
  );
};

export default WeatherApp;
