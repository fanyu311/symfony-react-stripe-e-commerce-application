import React, {useEffect, useState} from "react";

export interface Product{
    active: boolean;
    createdAt: Date;
    description: string;
    id: number;
    imageName: string;
    name: string;
    price: number;
}


// récupérer les products a parti ce moment ce hook
//  React 中的 useState 和 useEffect 钩子来获取产品数据。这是一个自定义 hook，通常用于在 React 组件中重用状态逻辑。这个 hook 的目的是从 /api/products 端点获取产品数据并将其保存在 Products 状态中。这样，当组件使用这个 hook 时，它将返回包含产品数据的状态值，并且在组件渲染时会触发对 /api/products 的请求。
export default function useProducts() {
    const [Products, setProducts] = useState<Product[]>([]);
    
    useEffect(() => {
        fetch('/api/products')
            .then(response => response.json())
            .then(json => setProducts(json));
    }, []);

    return Products;
}