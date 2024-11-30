import React, { useState } from "react";
import WeatherForm from "./components/WeatherForm";
import WeatherInfo from "./components/WeatherInfo";
import AboutModal from "./components/AboutModal";
import "bootstrap/dist/css/bootstrap.min.css";
import "./App.css";
import axios from "axios";

const App = () => {
  const [weather, setWeather] = useState(null);
  const [background, setBackground] = useState("default");

  const fetchWeather = async (city) => {
    try {
      const API_KEY = "YOUR_API_KEY";
      const response = await axios.get(`https://api.openweathermap.org/data/2.5/weather`, {
        params: { q: city, units: "metric", appid: API_KEY },
      });
      setWeather(response.data);

      // Arka plan değiştirme
      const weatherCondition = response.data.weather[0].main.toLowerCase();
      setBackground(weatherCondition);
    } catch (error) {
      setWeather(null);
      alert("Şehir bulunamadı. Lütfen geçerli bir şehir adı girin.");
    }
  };

  return (
    <div className={`app-container ${background}`}>
      <div className="container text-center">
        <h1 className="my-4">Hava Durumu Uygulaması</h1>
        <WeatherForm fetchWeather={fetchWeather} />
        <WeatherInfo weather={weather} />
        <AboutModal />
      </div>
    </div>
  );
};

export default App;
