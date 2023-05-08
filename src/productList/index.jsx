import React, { useState, useEffect } from 'react';
import Box from './components/Box';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import './index.scss';

const ProductList = () => {
  const [data, setData] = useState([]);
  const [checked, setChecked] = useState([]);
  const navigate = useNavigate();

  const routeChange = () => {
    const path = '/add-product';
    navigate(path);
  };

  useEffect(() => {
    axios.get('http://localhost/get.php', {
      headers: {
        'Access-Control-Allow-Origin': 'http://localhost:3000',
        'Content-Type': 'application/json'
      }
    }).then(response => {
      setData(response.data);
    });
  }, [handleClick]);


  const handleClick = () => {
    axios.post('http://localhost/delete.php', checked).then(() => {
      const newData = data.filter(product => !checked.includes(product.id));
      setData(newData);
      setChecked([]);
    }).catch(error => {
      console.log(error);
    });
  };

  return (
    <>
      <div className='title'>
        <h2>Product List</h2>
        <div className='buttons'>
          <button className='button' onClick={routeChange}>ADD</button>
          <button className='button' onClick={handleClick}>MASS DELETE</button>
        </div>
      </div>
      <div className='products'>
        {data.map(product => <Box key={product.id} data={product} setChecked={setChecked} />)}
      </div>
    </>
  );
};

export default ProductList;