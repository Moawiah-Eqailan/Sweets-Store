import React, { useEffect, useState } from "react";
import { FaShoppingCart, FaFacebook, FaInstagram } from "react-icons/fa";
import "bootstrap/dist/css/bootstrap.min.css";
import "../assets/css/style.css";
import logo from "../assets/images/logo3.png";
import { Link } from "react-router-dom";
import axios from "axios";

const Header = () => {
  const [categories, setCategories] = useState([]);
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [cartCount, setCartCount] = useState(0);

  useEffect(() => {
    const userData = localStorage.getItem("user");
    const token = localStorage.getItem("token");

    if (userData && token) {
      setIsLoggedIn(true);
    } else {
      setIsLoggedIn(false);
    }

    axios
      .get("http://127.0.0.1:8000/api/app")
      .then((response) => {
        setCategories(response.data.categories || []);
      })
      .catch((error) => {
        console.error("Error fetching categories:", error);
      });

    const fetchCartCount = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/cart");
        setCartCount(response.data.total_items || 0);
      } catch (error) {
        console.error("Error fetching cart count:", error);
      }
    };

    fetchCartCount();
  }, []);

  const handleLogout = () => {
    localStorage.removeItem("user");
    localStorage.removeItem("token");
    setIsLoggedIn(false);
  };

  return (
    <header
      className="header-top"
      style={{ position: "sticky", top: 0, zIndex: 999 }}
      dir="rtl"
    >
      <div className="container">
        <div className="row align-items-center">
          <div className="col-md-4">
            <div className="social-icons d-flex gap-3 justify-content-center justify-content-md-start">
              <Link to="https://www.facebook.com/" className="facebook">
                <FaFacebook size={18} />
              </Link>
              <Link to="https://www.instagram.com/" className="instagram">
                <FaInstagram size={18} />
              </Link>
              {isLoggedIn && (
                <Link to="/Users">
                  <i className="fa-regular fa-user"></i>
                </Link>
              )}
            </div>
          </div>
          <div className="col-md-4 text-center">
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
                />
              </h2>
            </Link>
          </div>
          <div className="col-md-4 text-end">
            <div className="search-cart-icons d-flex gap-4 justify-content-center justify-content-md-end">
              <Link to="/cart" className="icon-link cart-icon">
                <FaShoppingCart size={24} />
                <span className="cart-count">{cartCount}</span>
              </Link>
              {isLoggedIn ? (
                <button
                  onClick={handleLogout}
                  className="icon-link cart-icon btn btn-link"
                >
                  تسجيل الخروج
                </button>
              ) : (
                <>
                  <Link to="/Login" className="icon-link cart-icon">
                    تسجيل الدخول
                  </Link>
                  <Link to="/register" className="icon-link cart-icon">
                    انشاء حساب
                  </Link>
                </>
              )}
            </div>
          </div>
        </div>
      </div>
      <nav className="navbar navbar-expand-lg">
        <div className="container">
          <button
            className="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav"
          >
            <span className="navbar-toggler-icon"></span>
          </button>
          <div
            className="collapse navbar-collapse justify-content-center"
            id="navbarNav"
          >
            <ul className="navbar-nav">
              <li className="nav-item">
                <Link className="nav-link" to="/">
                  الرئيسية
                </Link>
              </li>
              <li className="nav-item">
                <Link className="nav-link" to="/about">
                  من نحن
                </Link>
              </li>
              <li className="nav-item dropdown">
                <Link
                  className="nav-link dropdown-toggle"
                  to="/menu"
                  data-bs-toggle="dropdown"
                  role="button"
                >
                  القائمة
                </Link>
                <ul className="dropdown-menu">
                  <li>
                    <Link className="dropdown-item" to="/menu">
                      جميع الحلويات
                    </Link>
                  </li>
                  {categories.length > 0 ? (
                    categories.map((category) => (
                      <li key={category.category_id}>
                        <Link
                          className="dropdown-item"
                          to={`/products?category_id=${category.category_id}`}
                        >
                          {category.category_name}
                        </Link>
                      </li>
                    ))
                  ) : (
                    <li className="dropdown-item text-muted">
                      لا توجد تصنيفات متاحة
                    </li>
                  )}
                </ul>
              </li>
              <li className="nav-item">
                <Link className="nav-link" to="/contact">
                  تواصل معنا
                </Link>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>
  );
};

export default Header;
