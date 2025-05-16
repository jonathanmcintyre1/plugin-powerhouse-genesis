
import { createRoot } from 'react-dom/client'
import App from './App.tsx'
import './index.css'

// Get the element with ID "copyprotect-root" from the WordPress admin page
const rootElement = document.getElementById("copyprotect-root");

// Only initialize the app if the root element exists
if (rootElement) {
  // Access the WordPress settings passed from PHP
  const settings = window.copyProtectSettings || {};
  
  createRoot(rootElement).render(
    <App settings={settings} />
  );
}
