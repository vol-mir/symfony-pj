// ./src/js/app.js
    
import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import './styles/app.css';
import Home from './components/Home';
import * as ReactDOMClient from 'react-dom/client';
    
const root = ReactDOMClient.createRoot(document.getElementById('root'));
root.render(<Home />);