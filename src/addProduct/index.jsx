import React from 'react';
import { useState } from 'react';
import { useNavigate } from "react-router-dom";
import axios from "axios";
import './index.scss'


const Addproduct = () => {
    const [data, setData] = useState({
        sku:'',
        price: '',
        name:'',
        productType:'DVD',
        size:'',
        weight: '',
        height: '',
        width: '',
        length: '',
        
    })
    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setData({ ...data, [name]: value });
      };
      
    let navigate = useNavigate(); 
    const routeChange = () =>{ 
      let path = `/`; 
      navigate(path);
    }
    const handleSubmit = (e) =>{
        e.preventDefault();
        // console.log('test')
        axios.get('http://localhost/get.php', {
            headers: {
              'Access-Control-Allow-Origin': 'http://localhost:3000/',
              'Content-Type': 'application/json'
            }
          }).then(response => {
            // handle the response data here
            var getData = response.data
            // console.log(getData)
            let skuexist = true
            getData.map(d => {
                // console.log(d)
                if(d['sku'] === data['sku']){
                    // console.log(d['sku'], data['sku'])
                    skuexist = true
                    return console.log('sku is repeated')
                }else{
                    // console.log('sku is not repeated')
                    skuexist = false
                }
                return skuexist
            })
            if(skuexist === false){
                // console.log('added to database')
                axios.post('http://localhost/post.php', JSON.stringify(data)).catch((error) => {
                console.log(error);})
            };
    })
    }
    const form = {
        'DVD' : <label>Size (MB):<input type="number"  name="size" id="size" value={data.size} onChange={handleInputChange} required/><p>Please, provide size</p></label>,
        'Book': <label>Weight (KG):<input type="number" name="weight" id="weight" value={data.weight} onChange={handleInputChange} required /><p>Please, provide weight</p></label>,
        'Furniture' : <><label>Height (CM):<input type="number" name="height" id="height" value={data.height} onChange={handleInputChange} required/></label><label>Width (CM):<input type="number" name="width" id="width" value={data.width} onChange={handleInputChange} required /></label><label>Length (CM):<input type="number" name="length" id="length" value={data.length} onChange={handleInputChange} required /></label><p>Please, provide dimensions</p></>,
    }
  return (
    <div>
        <form name='product_form' id='product_form' onSubmit={handleSubmit}>
        <div className='title'>
            <h2>Product List</h2>
            <div className='buttons'>
                <button className='button' type="submit">Save</button>
                <button className='button' onClick={routeChange}>Cancel</button>
            </div>
        </div>
            <label>
              SKU:
              <input 
                type="text" 
                name="sku"
                id="sku"
                value={data.sku}
                onChange={handleInputChange}  
                required 
              />
            </label>
            <label>
              Name:
              <input 
                type="text" 
                name="name"
                id="name"
                value={data.name}
                onChange={handleInputChange} 
                required
            />
            </label>
            <label>
              Price ($):
              <input 
                type="number" 
                name="price"
                id="price"
                value={data.price}
                onChange={handleInputChange}  
                required
              />
            </label>
            <label>
              Type Switcher:
              <select name="productType" id="productType" onChange={handleInputChange} required>
                <option value="DVD">DVD</option>
                <option value="Book">Book</option>
                <option value="Furniture">Furniture</option>
              </select>
            </label>
            {form[data.productType]}
        </form>
    </div>
  )
}

export default Addproduct