import React, { useState } from "react";

const WeatherForm = ({ fetchWeather }) => {
  const [city, setCity] = useState("");

  const handleSubmit = (e) => {
    e.preventDefault();
    if (city) fetchWeather(city);
  };

  return (
    <form onSubmit={handleSubmit} className="d-flex flex-column align-items-center">
      <input
        type="text"
        placeholder="Şehir adı girin"
        value={city}
        onChange={(e) => setCity(e.target.value)}
        className="form-control w-50 my-3"
      />
      <button type="submit" className="btn btn-primary">
        Hava Durumunu Getir
      </button>
    </form>
  );
};

export default WeatherForm;
