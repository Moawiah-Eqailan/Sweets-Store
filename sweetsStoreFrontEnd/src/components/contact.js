import React, { useState } from "react";
import Swal from "sweetalert2";
import "../assets/css/style.css";
import "bootstrap/dist/css/bootstrap.min.css";

const Contact = () => {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    subject: "",
    message: "",
  });

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    Swal.fire({
      title: "جاري الإرسال...",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    try {
      const response = await fetch("http://127.0.0.1:8000/api/ContactUs", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      });

      const data = await response.json();

      if (response.ok) {
        Swal.fire({
          icon: "success",
          title: "تم الإرسال بنجاح!",
          text: "تم إرسال رسالتك وسنقوم بالرد عليك قريبًا.",
        });
        setFormData({ name: "", email: "", subject: "", message: "" });
      } else {
        Swal.fire({
          icon: "error",
          title: "حدث خطأ!",
          text: "يرجى المحاولة مرة أخرى.",
        });
      }
    } catch (error) {
      Swal.fire({
        icon: "error",
        title: "خطأ في الاتصال!",
        text: "تأكد من اتصالك بالإنترنت وحاول مرة أخرى.",
      });
    }
  };

  return (
    <section className="contact-us py-5">
      <div className="container">
        <div className="row justify-content-center text-center">
          <div className="col-md-8">
            <h2 className="display-5 text-center mt-5">تواصل معنا</h2>
            <p className="lead">
              نحن هنا لمساعدتك! إذا كان لديك أي استفسارات أو ملاحظات، لا تتردد
              في الاتصال بنا.
            </p>
          </div>
        </div>
        <div className="row mt-5">
          <div className="col-md-6">
            <h3 className="display-6 mb-4">تواصل معنا</h3>
            <form onSubmit={handleSubmit}>
              <div className="mb-3">
                <input
                  type="text"
                  className="form-control"
                  name="name"
                  value={formData.name}
                  onChange={handleChange}
                  placeholder="الاسم الكامل"
                  required
                />
              </div>
              <div className="mb-3">
                <input
                  type="email"
                  className="form-control"
                  name="email"
                  value={formData.email}
                  onChange={handleChange}
                  placeholder="عنوان البريد الإلكتروني"
                  required
                />
              </div>
              <div className="mb-3">
                <input
                  type="text"
                  className="form-control"
                  name="subject"
                  value={formData.subject}
                  onChange={handleChange}
                  placeholder="الموضوع"
                  required
                />
              </div>
              <div className="mb-3">
                <textarea
                  className="form-control"
                  rows="5"
                  name="message"
                  value={formData.message}
                  onChange={handleChange}
                  placeholder="الرسالة"
                  required
                ></textarea>
              </div>
              <button
                type="submit"
                className="btn btn-primary rounded-pill px-5 py-3 text-uppercase fs-6"
              >
                إرسال
              </button>
            </form>
          </div>
          <div className="col-md-6">
            <div className="contact-info">
              <h3 className="display-6 mb-4">موقعنا على الخريطة</h3>
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3381.412436598118!2d35.9069959!3d31.9697692!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151ca1dd7bca79dd%3A0x9b0416f056ff0786!2sOrange%20Digital%20Village!5e0!3m2!1sen!2sjo!4v1707500000000"
                width="100%"
                height="350"
                style={{ border: "0" }}
                allowFullScreen
                loading="lazy"
              ></iframe>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Contact;
