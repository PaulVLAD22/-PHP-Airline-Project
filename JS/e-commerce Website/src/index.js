import React from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import LaptopApp from './Apps/LaptopApp';
import SmartphoneApp from './Apps/SmartphoneApp';
import TvApp from './Apps/TvApp';



ReactDOM.render(
  <React.StrictMode>
    <LaptopApp />
  </React.StrictMode>,
  document.getElementById('products-div')
);


