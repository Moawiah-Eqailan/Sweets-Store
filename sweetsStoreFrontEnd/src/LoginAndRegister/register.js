import React, { useState } from "react";
import { useNavigate , Link} from "react-router-dom";
import axios from "axios";
import "../assets/css/style.css";
import "bootstrap/dist/css/bootstrap.min.css";

const Register = () => {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    phone: "",
    password: "",
    password_confirmation: "",
  });
  
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
  
    if (formData.password !== formData.password_confirmation) {
      setError("كلمة المرور وتأكيد كلمة المرور غير متطابقتين");
      return;
    }
  
    setLoading(true);
    setError("");
  
    try {
      const response = await axios.post(
        "http://127.0.0.1:8000/api/registerUsers",
        formData
      );
  
      if (response.status === 200) {
        localStorage.setItem("token", response.data.token);
        localStorage.setItem("user", JSON.stringify(response.data.user));
        navigate("/");
      }
    } catch (error) {
      console.error("Error registering:", error);
      setError(
        error.response?.data?.message ||
          "حدث خطأ أثناء التسجيل. يرجى المحاولة مرة أخرى."
      );
    } finally {
      setLoading(false);
    }
  };
  return (
    <div style={{ minHeight: "100vh", position: "relative" }}>
      <div
        style={{
          background: "linear-gradient(135deg, #b1a05a 0%, #8c7d45 100%)",
          position: "fixed",
          top: 0,
          left: 0,
          width: "100%",
          height: "100%",
          zIndex: -1,
          opacity: 0.8,
        }}
      ></div>
      <div
        style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E")`,
          position: "fixed",
          top: 0,
          left: 0,
          width: "100%",
          height: "100%",
          zIndex: -1,
        }}
      ></div>

      <header
        style={{
          display: "flex",
          justifyContent: "space-between",
          alignItems: "center",
          padding: "1rem 1.5rem",
          color: "#fff",
        }}
      >
        <div style={{ fontWeight: "bold" }}>
          Sweet <span style={{ color: "#fff" }}>Store</span>
        </div>
      </header>

      <main style={{ padding: "3rem 1rem" }}>
        <div
          style={{
            maxWidth: "28rem",
            margin: "0 auto",
            background: "rgba(255, 255, 255, 0.95)",
            backdropFilter: "blur(10px)",
            borderRadius: "1rem",
            boxShadow: "0 25px 50px -12px rgba(0, 0, 0, 0.25)",
            overflow: "hidden",
          }}
        >
          <div style={{ textAlign: "center", padding: "2rem 0" }}>
            <i
              className="fas fa-user-plus"
              style={{
                fontSize: "3.5rem",
                color: "#b1a05a",
                marginBottom: "1rem",
              }}
            ></i>
            <h2
              style={{
                fontSize: "1.5rem",
                fontWeight: "bold",
                color: "#1a202c",
              }}
            >
              إنشاء حساب جديد
            </h2>
            <p style={{ color: "#718096", marginTop: "0.5rem" }}>
              انضم إلى{" "}
              <span style={{ color: "#b1a05a", fontWeight: "bold" }}>
                مخبزنا
              </span>
            </p>
          </div>

          <form onSubmit={handleSubmit} style={{ padding: "0 2rem 1.5rem" }}>
            <div style={{ position: "relative", marginBottom: "1.5rem" }}>
              <input
                type="text"
                name="name"
                placeholder="الاسم الكامل"
                value={formData.name}
                onChange={handleChange}
                style={{
                  width: "100%",
                  padding: "0.75rem 1rem",
                  paddingLeft: "3rem",
                  borderRadius: "0.5rem",
                  border: "1px solid #e2e8f0",
                  transition: "all 0.3s ease",
                  outline: "none",
                }}
                required
              />
              <i
                className="fas fa-user"
                style={{
                  position: "absolute",
                  left: "1rem",
                  top: "50%",
                  transform: "translateY(-50%)",
                  color: "#b1a05a",
                }}
              ></i>
            </div>

            <div style={{ position: "relative", marginBottom: "1.5rem" }}>
              <input
                type="email"
                name="email"
                placeholder="البريد الإلكتروني"
                value={formData.email}
                onChange={handleChange}
                style={{
                  width: "100%",
                  padding: "0.75rem 1rem",
                  paddingLeft: "3rem",
                  borderRadius: "0.5rem",
                  border: "1px solid #e2e8f0",
                  transition: "all 0.3s ease",
                  outline: "none",
                }}
                required
              />
              <i
                className="fas fa-envelope"
                style={{
                  position: "absolute",
                  left: "1rem",
                  top: "50%",
                  transform: "translateY(-50%)",
                  color: "#b1a05a",
                }}
              ></i>
            </div>

            <div style={{ position: "relative", marginBottom: "1.5rem" }}>
              <input
                type="text"
                name="phone"
                placeholder="رقم الهاتف"
                value={formData.phone}
                onChange={handleChange}
                style={{
                  width: "100%",
                  padding: "0.75rem 1rem",
                  paddingLeft: "3rem",
                  borderRadius: "0.5rem",
                  border: "1px solid #e2e8f0",
                  transition: "all 0.3s ease",
                  outline: "none",
                }}
                required
              />
              <i
                className="fas fa-phone-alt"
                style={{
                  position: "absolute",
                  left: "1rem",
                  top: "50%",
                  transform: "translateY(-50%)",
                  color: "#b1a05a",
                }}
              ></i>
            </div>

            <div style={{ position: "relative", marginBottom: "1.5rem" }}>
              <input
                type="password"
                name="password"
                placeholder="كلمة المرور"
                value={formData.password}
                onChange={handleChange}
                style={{
                  width: "100%",
                  padding: "0.75rem 1rem",
                  paddingLeft: "3rem",
                  borderRadius: "0.5rem",
                  border: "1px solid #e2e8f0",
                  transition: "all 0.3s ease",
                  outline: "none",
                }}
                required
              />
              <i
                className="fas fa-lock"
                style={{
                  position: "absolute",
                  left: "1rem",
                  top: "50%",
                  transform: "translateY(-50%)",
                  color: "#b1a05a",
                }}
              ></i>
            </div>

            <div style={{ position: "relative", marginBottom: "1.5rem" }}>
              <input
                type="password"
                name="password_confirmation"
                placeholder="تأكيد كلمة المرور"
                value={formData.password_confirmation}
                onChange={handleChange}
                style={{
                  width: "100%",
                  padding: "0.75rem 1rem",
                  paddingLeft: "3rem",
                  borderRadius: "0.5rem",
                  border: "1px solid #e2e8f0",
                  transition: "all 0.3s ease",
                  outline: "none",
                }}
                required
              />
              <i
                className="fas fa-lock"
                style={{
                  position: "absolute",
                  left: "1rem",
                  top: "50%",
                  transform: "translateY(-50%)",
                  color: "#b1a05a",
                }}
              ></i>
            </div>

            {error && (
              <p
                style={{
                  color: "red",
                  fontSize: "0.875rem",
                  textAlign: "center",
                }}
              >
                {error}
              </p>
            )}

            <button
              type="submit"
              style={{
                width: "100%",
                padding: "0.75rem 1rem",
                backgroundColor: "#b1a05a",
                color: "white",
                border: "none",
                borderRadius: "0.5rem",
                cursor: "pointer",
                transition: "all 0.3s ease",
              }}
            >
              إنشاء حساب
            </button>

            <div
              style={{
                textAlign: "center",
                marginTop: "1rem",
                fontSize: "0.875rem",
                color: "#4a5568",
              }}
            >
              <span>هل لديك حساب؟</span>{" "}
              <Link
                to="/login"
                style={{
                  color: "#b1a05a",
                  fontWeight: "bold",
                  textDecoration: "none",
                }}
              >
                تسجيل الدخول
              </Link>
            </div>
          </form>
        </div>
      </main>
    </div>
  );
};

export default Register;
