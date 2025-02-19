import { FaFacebook, FaInstagram } from "react-icons/fa";
import React from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "../assets/css/style.css";
import { Link } from "react-router-dom";
import logo from "../assets/images/logo3.png";

const Footer = () => {
  return (
    <footer className="footer" dir="rtl">
      <div className="container">
        <div className="row g-5">
          <div className="col-lg-4 col-md-6">
            <Link to="/" className="logo">
              <h2
                className="display-5"
                style={{ fontFamily: " 'Cairo', sans-serif" }}
              >
                <img
                  width={"100px"}
                  src={logo}
                  alt="Sweets Store Logo"
                  className="img-fluid"
                />{" "}
              </h2>
            </Link>
            <p className="footer-description">
              انضم إلينا في رحلة من الذوق والتقاليد في متجر الحلويات، حيث نقدم
              أشهى وألذ الحلويات العربية والعالمية المصنوعة بحب وإتقان.
            </p>
          </div>

          <div className="col-lg-4 col-md-6">
            <div className="widget">
              <h4 className="widget-title">اتصل بنا</h4>
              <ul className="list-unstyled contact-info">
                <li>
                  <i className="fas fa-map-marker-alt"></i>
                  الأردن، عمان
                </li>
                <li>
                  <i className="fas fa-phone"></i>
                  123-456-7890
                </li>
                <li>
                  <i className="fas fa-envelope"></i>
                  <Link to="mailto:sweets.store@sweets.com">
                    sweets.store@sweets.com
                  </Link>
                </li>
              </ul>
            </div>
          </div>

          <div className="col-lg-2 col-md-6">
            <div className="widget">
              <h4 className="widget-title">روابط سريعة</h4>
              <ul className="list-unstyled">
                <li>
                  <Link to="/">الرئيسية</Link>
                </li>
                <li>
                  <Link to="/menu">القائمة الحلويات</Link>
                </li>
                <li>
                  <Link to="/about">من نحن</Link>
                </li>
                <li>
                  <Link to="/contact">اتصل بنا</Link>
                </li>
              </ul>
            </div>
          </div>

          <div className="col-lg-2 col-md-6">
            <h4 className="widget-title">تابعنا</h4>
            <div className="social-icons d-flex gap-3 justify-content-center justify-content-md-start">
              <Link to="https://www.facebook.com/" className="facebook">
                <FaFacebook size={18} />
              </Link>
              <Link to="https://www.instagram.com/" className="instagram">
                <FaInstagram size={18} />
              </Link>
            </div>
          </div>
        </div>
      </div>

      <div className="container">
        <div className="footer-bottom text-center mt-5">
          <p className="copyright mb-0">
            © 2025 Sweets <span style={{ color: "#b1a05a" }}>Store</span> . جميع
            الحقوق محفوظة
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
