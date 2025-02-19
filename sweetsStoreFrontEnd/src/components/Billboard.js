import React from "react";
import { useEffect } from "react";
import { Link } from "react-router-dom";

import "../assets/css/style.css";
import "bootstrap/dist/css/bootstrap.min.css";
import banner2 from "../assets/images/banner2.jpg";
import banner3 from "../assets/images/banner3.jpg";
import banner4 from "../assets/images/banner4.jpg";
import banner5 from "../assets/images/banner5.jpg";
const Billboard = () => {
  useEffect(() => {
    const script1 = document.createElement("script");
    script1.src = "assets/js/jquery-1.11.0.min.js";
    script1.async = true;
    document.body.appendChild(script1);

    const script2 = document.createElement("script");
    script2.src =
      "https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js";
    script2.integrity =
      "sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm";
    script2.crossOrigin = "anonymous";
    document.body.appendChild(script2);

    const script3 = document.createElement("script");
    script3.src = "https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js";
    script3.async = true;
    document.body.appendChild(script3);

    const script4 = document.createElement("script");
    script4.src = "assets/js/plugins.js";
    script4.async = true;
    document.body.appendChild(script4);

    const script5 = document.createElement("script");
    script5.src = "assets/js/script.js";
    script5.async = true;
    document.body.appendChild(script5);

    return () => {
      document.body.removeChild(script1);
      document.body.removeChild(script2);
      document.body.removeChild(script3);
      document.body.removeChild(script4);
      document.body.removeChild(script5);
    };
  }, []);
  return (
    <>
      <section
        id="billboard"
        dir="rtl"
        style={{
          fontFamily: "'Cairo', sans-serif",
          margin: "0",
          padding: "0",
          direction: "rtl",
        }}
      >
        <div className="main-swiper swiper">
          <div className="swiper-wrapper">
            <div className="swiper-slide jarallax py-5">
              <img src={banner4} className="img-fluid jarallax-img" />
              <div className="text-content text-center py-5 my-5">
                <div className="container">
                  <div className="row justify-content-center">
                    <div className="col-md-8">
                      <h2 style={{ fontFamily: " 'Lemonada', serif;" }}>
                        اكتشف عالمًا من النكهات الرائعة
                      </h2>
                      <p>
                        يستخدم خبراء الخبازين لدينا فقط أفضل المكونات، مما يضمن
                        أن كل قطعة تحفة فنية تعكس المعايير الاستثنائية التي
                        نلتزم بها.
                      </p>
                      <a
                        href="#categories"
                        className="btn btn-primary rounded-pill px-5 py-3 mt-3 text-uppercase fs-6"
                      >
                        تسوق الآن
                      </a>
                      <br />
                      <Link
                        to="/Menu"
                        id="download-menu-btn"
                        className="btn btn-primary rounded-pill px-5 py-3 mt-3 text-uppercase fs-6"
                      >
                        القائمة الحلويات
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="swiper-slide jarallax py-5">
            <img src={banner5} className="img-fluid jarallax-img" />
              <div className="text-content text-center py-5 my-5 text-white">
                <div className="container">
                  <div className="row justify-content-center">
                    <div className="col-md-8">
                      <h2 style={{ fontFamily: " 'Lemonada', serif;" }}>
                        اكتشف عالمًا من النكهات الرائعة
                      </h2>
                      <p>
                        يستخدم خبراء الخبازين لدينا فقط أفضل المكونات، مما يضمن
                        أن كل قطعة تحفة فنية تعكس المعايير الاستثنائية التي
                        نلتزم بها.
                      </p>
                      <Link
                        to="/menu"
                        className="btn btn-primary rounded-pill px-5 py-3 mt-3 text-uppercase fs-6"
                      >
                        تسوق الآن
                      </Link>
                      <br />
                      <Link
                        to="/Menu"
                        id="download-menu-btn"
                        className="btn btn-primary rounded-pill px-5 py-3 mt-3 text-uppercase fs-6"
                      >
                        القائمة الحلويات
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div className="swiper-slide jarallax py-5">
            <img src={banner3} className="img-fluid jarallax-img" />
              <div className="text-content text-center py-5 my-5">
                <div className="container">
                  <div className="row justify-content-center">
                    <div className="col-md-8">
                      <h2 style={{ fontFamily: " 'Lemonada', serif;" }}>
                        اكتشف عالمًا من النكهات الرائعة
                      </h2>
                      <p>
                        يستخدم خبراء الخبازين لدينا فقط أفضل المكونات، مما يضمن
                        أن كل قطعة تحفة فنية تعكس المعايير الاستثنائية التي
                        نلتزم بها.
                      </p>
                      <Link
                        to="/menu"
                        className="btn btn-primary rounded-pill px-5 py-3 mt-3 text-uppercase fs-6"
                      >
                        تسوق الآن
                      </Link>
                      <br />
                      <Link
                        to="/Menu"
                        id="download-menu-btn"
                        className="btn btn-primary rounded-pill px-5 py-3 mt-3 text-uppercase fs-6"
                      >
                        القائمة الحلويات
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div className="swiper-slide jarallax py-5">
            <img src={banner2} className="img-fluid jarallax-img" />
              <div className="text-content text-center py-5 my-5">
                <div className="container">
                  <div className="row justify-content-center">
                    <div className="col-md-8">
                      <h2 style={{ fontFamily: " 'Lemonada', serif;" }}>
                        اكتشف عالمًا من النكهات الرائعة
                      </h2>
                      <p>
                        يستخدم خبراء الخبازين لدينا فقط أفضل المكونات، مما يضمن
                        أن كل قطعة تحفة فنية تعكس المعايير الاستثنائية التي
                        نلتزم بها.
                      </p>
                      <Link
                        to="/menu"
                        className="btn btn-primary rounded-pill px-5 py-3 mt-3 text-uppercase fs-6"
                      >
                        تسوق الآن
                      </Link>
                      <br />
                      <Link
                        to="/Menu"
                        id="download-menu-btn"
                        className="btn btn-primary rounded-pill px-5 py-3 mt-3 text-uppercase fs-6"
                      >
                        القائمة الحلويات
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div className="swiper-pagination"></div>

          <div className="swiper-prev main-swiper-left">
            <svg className="arrow-left" width="24" height="24">
              <use href="#arrow-left"></use>
            </svg>
          </div>
          <div className="swiper-next main-swiper-right">
            <svg className="arrow-right" width="24" height="24">
              <use href="#arrow-right"></use>
            </svg>
          </div>
        </div>
      </section>
    </>
  );
};
export default Billboard;
