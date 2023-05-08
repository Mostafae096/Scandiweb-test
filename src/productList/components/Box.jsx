import React from 'react'
import { useState } from 'react';
import './box.scss'

const attributes = (data) => {
    if (data['productType'] === 'DVD'){
        return 'Size: ' + data['size'] +' MB'
    } else if (data['productType'] === 'Book') {
        return 'Weight: ' + data['weight'] +' Kg'
    } else if (data['productType'] === 'Furniture') {
        return 'Dimensions: ' + data['height'] +'x' + data['width'] +'x' + data['length']
    }
}


const Box = ({data , setChecked}) => {
    const [isChecked, setIsChecked] = useState(false);
    const handleOnChange = () => {
        setIsChecked(!isChecked);
        setChecked(checked => [...checked, data['id']])
      };
  return (
    <div className='box'>
        <input type="checkbox" className="delete-checkbox" checked={isChecked} onChange={handleOnChange}/>
        <div className='info'>
            <p>{data['sku']}</p>
            <p>{data['name']}</p>
            <p>{data['price']} $</p>
            <p>{attributes(data)}</p>
        </div>
    </div>
  )
}

export default Box