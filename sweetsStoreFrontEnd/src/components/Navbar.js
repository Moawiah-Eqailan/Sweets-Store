import React from 'react';
import "bootstrap/dist/css/bootstrap.min.css";
import "../assets/css/style.css";
import { useEffect } from "react";
import {Link} from "react-router-dom";

const NavigationBar = () => {

   useEffect(() => {
    const script = document.createElement("script");
    script.src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js";
    script.integrity = "sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm";
    script.crossOrigin = "anonymous";
    script.async = true;
    document.body.appendChild(script);

    return () => {

      document.body.removeChild(script);
    };
  }, []);

  
  return (
    <nav className="navbar navbar-expand-lg" >
    <div className="container">
      <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span className="navbar-toggler-icon"></span>
      </button>
      <div className="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul className="navbar-nav">
          <li className="nav-item">
            <Link className="nav-link" to="/">الرئيسية</Link>
          </li>
          <li className="nav-item">
            <Link className="nav-link" to="./about">من نحن</Link>
          </li>
          <li className="nav-item dropdown">
            <Link className="nav-link dropdown-toggle" to="./Menu" data-bs-toggle="dropdown">القائمة </Link>
            <ul className="dropdown-menu">
              <li><Link className="dropdown-item" to="./Menu">جميع الحلويات</Link></li>
              <li><Link className="dropdown-item" to="#">الدونات</Link></li>
              <li><Link className="dropdown-item" to="#">الكيك</Link></li>
              <li><Link className="dropdown-item" to="#">الكنافة</Link></li>
              <li><Link className="dropdown-item" to="#">البقلاوة</Link></li>
            </ul>
          </li>
        
          <li className="nav-item">
            <Link className="nav-link" to="./contact">تواصل معنا</Link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  );
};

export default NavigationBar;
