import React from "react";
import {Link} from "react-router-dom";
import "../assets/css/style.css";
import "bootstrap/dist/css/bootstrap.min.css";

const AboutUs = () => {
  return (
    <section className="about-us py-5" dir="rtl">
      <div className="container">
        <div className="row justify-content-center text-center">
          <div className="col-md-8">
            <h2 className="display-5 text-center mt-5">
              عن <span style={{color: "#b1a05a"}}>متجرنا</span>
            </h2>
            <p className="lead">
              <span style={{color:" #b1a05a"}}>متجرنا </span>هو متجر متخصص في إنتاج
              وبيع الحلويات الشامية الأصيلة المصنوعة من مكونات عالية الجودة.
            </p>
            <p className="lead">
              نحن نؤمن أن الحلويات ليست مجرد طعام، بل هي تجربة تجلب الفرح إلى
              القلب
            </p>
          </div>
        </div>
        <div className="row mt-5">
          <div className="col-md-6">
            <img
              src="https://i.pinimg.com/736x/11/8a/73/118a730672547150c4f32b9d9dfa83f9.jpg"
              alt="About the Shop"
              className="img-fluid rounded"
            />
          </div>
          <div className="col-md-6">
            <h3 className="display-6 mb-4">قصتنا</h3>
            <p>
              بدأت رحلتنا منذ أكثر من 10 سنوات عندما قررنا مشاركة حبنا للحلويات
              مع العالم. بدأنا كمحل صغير في حيّنا، ثم تطورنا لنصبح وجهة لعشاق
              الحلويات من مختلف أنحاء المنطقة.
            </p>
            <p>
              نحن نستخدم فقط أفضل المكونات الطبيعية لصناعة مجموعة واسعة من
              الحلويات، مع مراعاة جميع الأذواق والمناسبات.
            </p>
            <Link
              to="/contact"
              className="btn btn-primary rounded-pill px-5 py-3 mt-3 text-uppercase fs-6"
            >
              اتصل بنا
            </Link>
          </div>
        </div>
      </div>
    </section>
  );
};

export default AboutUs;
