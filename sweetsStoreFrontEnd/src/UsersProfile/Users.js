import React, { useState, useEffect } from "react";
import "../assets/css/style.css";
import "bootstrap/dist/css/bootstrap.min.css";
import { Link } from "react-router-dom";

const UserProfile = () => {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    address: "",
  });

  useEffect(() => {
    const userData = JSON.parse(localStorage.getItem("user"));

    if (userData) {
      setFormData({
        name: userData.name || "",
        email: userData.email || "",
        phone: userData.phone || "",
        address: userData.address || "",
      });
    }
  }, []);

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  return (
    <>
      <br />
      <br />
      <div className="container">
        <div
          style={{
            textAlign: "center",
            marginBottom: "30px",
          }}
        >
          <h2 style={{ fontFamily: "'Lemonada', serif" }}>معلومات المستخدم</h2>
          <span style={{ display: "block", textAlign: "center" }}>
            الملف الشخصي الخاص بك
          </span>
        </div>
     
       
        <div>
          <div>
            <div className="usersProfile">
              <div className="product-info" style={{ padding: "20px" }}>
                <form>
                  <div className="info-section">
                    <div
                      className="info-row"
                      style={{
                        marginBottom: "15px",
                        padding: "10px",
                        borderRadius: "8px",
                      }}
                    >
                      <span
                        style={{
                          fontWeight: "bold",
                          display: "block",
                          marginBottom: "8px",
                        }}
                      >
                        الاسم
                      </span>
                      <input
                        type="text"
                        name="name"
                        value={formData.name}
                        onChange={handleChange}
                        className="form-control"
                        readOnly
                        disabled
                        style={{
                          direction: "rtl",
                          padding: "8px",
                          borderRadius: "6px",
                          border: "1px solid #ddd",
                        }}
                      />
                    </div>

                    <div
                      className="info-row"
                      style={{
                        marginBottom: "15px",
                        padding: "10px",
                        borderRadius: "8px",
                      }}
                    >
                      <span
                        style={{
                          fontWeight: "bold",
                          display: "block",
                          marginBottom: "8px",
                        }}
                      >
                        البريد الإلكتروني
                      </span>
                      <input
                        type="email"
                        name="email"
                        value={formData.email}
                        onChange={handleChange}
                        className="form-control"
                        readOnly
                        disabled
                        style={{
                          direction: "rtl",
                          padding: "8px",
                          borderRadius: "6px",
                          border: "1px solid #ddd",
                        }}
                      />
                    </div>

                    <div
                      className="info-row"
                      style={{
                        marginBottom: "15px",
                        padding: "10px",
                        borderRadius: "8px",
                      }}
                    >
                      <span
                        style={{
                          fontWeight: "bold",
                          display: "block",
                          marginBottom: "8px",
                        }}
                      >
                        رقم الهاتف
                      </span>
                      <input
                        type="tel"
                        name="phone"
                        value={formData.phone}
                        onChange={handleChange}
                        className="form-control"
                        readOnly
                        disabled
                        style={{
                          direction: "rtl",
                          padding: "8px",
                          borderRadius: "6px",
                          border: "1px solid #ddd",
                        }}
                      />
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <br />
        <div
          className="d-flex justify-content-center"
          style={{ marginTop: "20px" }}
        >
          <Link
            to="/UserOrders"
            style={{
              width: "100%",
              textDecoration: "none",
            }}
          >
            <button
              className="add-to-cart"
              style={{
                width: "50%",
                color: "white",
                padding: "10px",
                border: "none",
                borderRadius: "8px",
                cursor: "pointer",
                display: "flex",
                alignItems: "center",
                justifyContent: "center",
                gap: "8px",
              }}
            >
              <span>جميع الطلبات</span>
            </button>
          </Link>
        </div>
      </div>
      <br />
      <br />
    </>
  );
};

export default UserProfile;
