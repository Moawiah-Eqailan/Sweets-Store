import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Header from "./components/Header";
import Footer from "./components/Footer";

import AboutUs from "./components/AboutUs";
import Contact from "./components/contact";

import BestProducts from "./components/BestProducts";
import Menu from "./components/Menu";
import Details from "./components/Details";
import Cart from "./components/cart";
import Checkout from "./components/Checkout";
import Products from "./components/products";
import Billboard from "./components/Billboard";
import Offers from "./components/Offers";
import Filter from "./components/Filter";
import SideBarPage from "./components/SideBarPage";

import Users from "./UsersProfile/Users";
import UserOrders from "./UsersProfile/UserOrders";

import Login from "./LoginAndRegister/Login";
import Register from "./LoginAndRegister/register";

import "./assets/css/style.css";

function MainLayout() {
  return (
    <>
      <Header />
      <Routes>
        <Route exact path="/" element={
          <>
            <Billboard />
            <BestProducts />
          </>
        } />
        <Route exact path="/About" element={<AboutUs />} />
        <Route exact path="/Contact" element={<Contact />} />
        <Route exact path="/Menu" element={<Menu />} />
        <Route exact path="/Offers" element={<Offers />} />
        <Route exact path="/Details" element={<Details />} />
        <Route exact path="/Cart" element={<Cart />} />
        <Route exact path="/Checkout" element={<Checkout />} />
        <Route exact path="/products" element={<Products />} />
        <Route exact path="/Filter" element={<Filter />} />
        <Route exact path="/SideBarPage" element={<SideBarPage />} />

        <Route exact path="/Users" element={<Users />} />
        <Route exact path="/UserOrders" element={<UserOrders />} />
      </Routes>
      <Footer />
    </>
  );
}



function App() {
  return (
    <Router>
      <Routes>
        <Route path="/*" element={<MainLayout />} />
        <Route path="/Login" element={<Login />} />
        <Route path="/Register" element={<Register />} />
      </Routes>
    </Router>
  );
}

export default App;