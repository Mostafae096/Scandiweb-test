import React, { useState, useEffect } from 'react';
import Box from './components/Box';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import './index.scss';

// delete checked boxes
const handleClick = (e, checked, setChecked, data, setData, navigate) => {
  e.preventDefault();
  
  axios.post('http://localhost/api/delete.php', checked).then(() => {
    const newData = data.filter(product => !checked.includes(product.id));
    setData(newData);
    setChecked([]);
  }).catch(error => {
    console.log(error);
  });
  navigate('/');
};


const ProductList = () => {
  const [checked, setChecked] = useState([]);
  const [data, setData] = useState([]);
  const navigate = useNavigate();
  const routeChange = () => {
    const path = '/add-product';
    navigate(path);
  };
  useEffect(() => {
    axios.get('http://localhost/api/get.php').then(response => {
      setData(response.data);
    });
  }, [handleClick]);
  return (
    <>
      <div className='title'>
        <h2>Product List</h2>
        <div className='buttons'>
          <button className='button' onClick={routeChange}>ADD</button>
          <button className='button' onClick={e => handleClick(e, checked, setChecked, data, setData, navigate)}>MASS DELETE</button>
        </div>
      </div>
      <div className='products'>
        {data.map(product => <Box key={product.id} data={product} setChecked={setChecked} />)}
      </div>
    </>
  );
};

export default ProductList;