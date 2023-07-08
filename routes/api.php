<?php


return [
    [
        'GROUP', '/api', [
     
            ['GET', '/products', ['api\ProductController', 'index']],
            ['GET', '/products/recetas', ['api\ProductController', 'recetas']],
            ['GET', '/products/{id}', ['api\ProductController', 'show']],
        
            ['GET', '/facturas', ['api\FacturaController', 'index']],
            ['GET', '/facturas/{nro_factura}', ['api\FacturaController', 'getInvoce']],
            ['POST', '/facturas/create', ['api\FacturaController', 'postCreateInvoce']]
         
        ]
    ]
];
