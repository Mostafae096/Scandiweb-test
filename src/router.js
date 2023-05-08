import {BrowserRouter as Router, Route, Routes} from "react-router-dom";
import React from 'react'
import ProductList from "./productList";
import Addproduct from "./addProduct";

const Routing = () => {
  return (
    <Router>
        <Routes>
            <Route path="/" element={<ProductList />} />
            <Route path="add-product" element={<Addproduct />} />
        </Routes>
    </Router>
  )
}

export default Routing