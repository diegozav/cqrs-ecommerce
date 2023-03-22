Feature: Search products with filters
    In order buy products
    As a user
    I want to search available products for sale

    Scenario: Search products with filter applied
        Given There are products with the following details:
            | id   | sku           | type      | name                          | is_published | short_description | description                                                                                                                                                                            | in_stock | stock | categories                                                                | images                                                                | price |
            | 139  | MH09-L-Blue   | variation | Abominable Hoodie-L-Blue      | true         | NULL              | It took CoolTech weather apparel know-how and lots of wind-resistant fabric to get the Abominable Hoodie just right. Blue heather hoodie.                                       | true     | 100   | Clothing>Men>Tops>Hoodies & Sweatshirts                                   | http://eimages.valtim.com/acme-images/product/m/h/mh09-blue_main.jpg  | 69    |
            | 647  | MT07-L-Gray   | variation | Argus All-Weather Tank-L-Gray | true         | NULL              | The Argus All-Weather Tank is sure to become your favorite base layer or go-to cover for hot outdoor workouts.Dark gray polyester spandex tank.                                        | true     | 100   | Clothing>Men>Tops>Tanks,Clothing>Collections>Eco Friendly                 | http://eimages.valtim.com/acme-images/product/m/t/mt07-gray_main.jpg  | 22    |
            | 1585 | WB03-L-Green  | variation | Celeste Sports Bra-L-Green    | true         | NULL              | Whatever your goals for the day's workout, the Celeste Sports Bra lets you do it in comfort and coolness, plus enhanced support and shaping.                                           | true     | 100   | Clothing>Women>Tops>Bras & Tanks,Clothing>Collections>Performance Fabrics | http://eimages.valtim.com/acme-images/product/w/b/wb03-green_main.jpg | 39    |
            | 2    | MH01-XS-Black | variation | Chaz Kangeroo Hoodie-XS-Black | true         | NULL              | Ideal for cold-weather training or work outdoors, the Chaz Hoodie promises superior warmth with every wear.                                                                            | true     | 100   | Clothing>Men>Tops>Hoodies & Sweatshirts,Clothing>Collections>Eco Friendly | http://eimages.valtim.com/acme-images/product/m/h/mh01-black_main.jpg | 52    |
            | 1281 | WJ09-L-Blue   | variation | Jade Yoga Jacket-L-Blue       | true         | NULL              | If only all your other jackets were as comfortable as the relaxed-fit Jade Yoga Jacket, perfect for use during stretching, biking to and from studio or strolling on breezy fall days. | true     | 100   | Clothing>Women>Tops>Jackets,Clothing>Collections>Erin Recommends,Clothing | http://eimages.valtim.com/acme-images/product/w/j/wj09-blue_main.jpg  | 32    |
        When I send a POST request to "/products" with body:
        """
        {
            "filters": [
                {
                    "field": "name",
                    "operator": "CONTAINS",
                    "value": "Hoo"
                }
            ],
            "orderBy": null,
            "order": null,
            "limit": 10,
            "offset": 0
        }
        """
        Then the response status code should be 200
        And the response content should be:
        """
        {
            "hits": [
                {
                    "sku": "MH09-L-Blue",
                    "type": "variation",
                    "name": "Abominable Hoodie-L-Blue",
                    "isPublished": true,
                    "shortDescription": "NULL",
                    "description": "It took CoolTech weather apparel know-how and lots of wind-resistant fabric to get the Abominable Hoodie just right. Blue heather hoodie.",
                    "inStock": true,
                    "categories": "Clothing>Men>Tops>Hoodies & Sweatshirts",
                    "productImages": "http://eimages.valtim.com/acme-images/product/m/h/mh09-blue_main.jpg",
                    "price": 69
                },
                {
                    "sku": "MH01-XS-Black",
                    "type": "variation",
                    "name": "Chaz Kangeroo Hoodie-XS-Black",
                    "isPublished": true,
                    "shortDescription": "NULL",
                    "description": "Ideal for cold-weather training or work outdoors, the Chaz Hoodie promises superior warmth with every wear.",
                    "inStock": true,
                    "categories": "Clothing>Men>Tops>Hoodies & Sweatshirts,Clothing>Collections>Eco Friendly",
                    "productImages": "http://eimages.valtim.com/acme-images/product/m/h/mh01-black_main.jpg",
                    "price": 52
                }
            ],
            "total": 2
        }
        """

    Scenario: Search products with order and limit applied
        Given There are products with the following details:
            | id   | sku           | type      | name                          | is_published | short_description | description                                                                                                                                                                            | in_stock | stock | categories                                                                | images                                                                | price |
            | 139  | MH09-L-Blue   | variation | Abominable Hoodie-L-Blue      | true         | NULL              | It took CoolTech weather apparel know-how and lots of wind-resistant fabric to get the Abominable Hoodie just right. Blue heather hoodie.                                       | true     | 100   | Clothing>Men>Tops>Hoodies & Sweatshirts                                   | http://eimages.valtim.com/acme-images/product/m/h/mh09-blue_main.jpg  | 69    |
            | 647  | MT07-L-Gray   | variation | Argus All-Weather Tank-L-Gray | true         | NULL              | The Argus All-Weather Tank is sure to become your favorite base layer or go-to cover for hot outdoor workouts.Dark gray polyester spandex tank.                                        | true     | 100   | Clothing>Men>Tops>Tanks,Clothing>Collections>Eco Friendly                 | http://eimages.valtim.com/acme-images/product/m/t/mt07-gray_main.jpg  | 22    |
            | 1585 | WB03-L-Green  | variation | Celeste Sports Bra-L-Green    | true         | NULL              | Whatever your goals for the day's workout, the Celeste Sports Bra lets you do it in comfort and coolness, plus enhanced support and shaping.                                           | true     | 100   | Clothing>Women>Tops>Bras & Tanks,Clothing>Collections>Performance Fabrics | http://eimages.valtim.com/acme-images/product/w/b/wb03-green_main.jpg | 39    |
            | 2    | MH01-XS-Black | variation | Chaz Kangeroo Hoodie-XS-Black | true         | NULL              | Ideal for cold-weather training or work outdoors, the Chaz Hoodie promises superior warmth with every wear.                                                                            | true     | 100   | Clothing>Men>Tops>Hoodies & Sweatshirts,Clothing>Collections>Eco Friendly | http://eimages.valtim.com/acme-images/product/m/h/mh01-black_main.jpg | 52    |
            | 1281 | WJ09-L-Blue   | variation | Jade Yoga Jacket-L-Blue       | true         | NULL              | If only all your other jackets were as comfortable as the relaxed-fit Jade Yoga Jacket, perfect for use during stretching, biking to and from studio or strolling on breezy fall days. | true     | 100   | Clothing>Women>Tops>Jackets,Clothing>Collections>Erin Recommends,Clothing | http://eimages.valtim.com/acme-images/product/w/j/wj09-blue_main.jpg  | 32    |
        When I send a POST request to "/products" with body:
        """
        {
            "filters": [],
            "orderBy": "name",
            "order": "desc",
            "limit": 3,
            "offset": 0
        }
        """
        Then the response status code should be 200
        And the total number of products should be 3
        And the response content should be:
        """
        {
            "hits": [
                {
                    "sku":"WJ09-L-Blue",
                    "type":"variation",
                    "name":"Jade Yoga Jacket-L-Blue",
                    "isPublished":true,
                    "shortDescription":"NULL",
                    "description":"If only all your other jackets were as comfortable as the relaxed-fit Jade Yoga Jacket, perfect for use during stretching, biking to and from studio or strolling on breezy fall days.",
                    "inStock":true,
                    "categories":"Clothing>Women>Tops>Jackets,Clothing>Collections>Erin Recommends,Clothing",
                    "productImages":"http:\/\/eimages.valtim.com\/acme-images\/product\/w\/j\/wj09-blue_main.jpg",
                    "price":32
                },
                {
                    "sku":"MH01-XS-Black",
                    "type":"variation",
                    "name":"Chaz Kangeroo Hoodie-XS-Black",
                    "isPublished":true,
                    "shortDescription":"NULL",
                    "description":"Ideal for cold-weather training or work outdoors, the Chaz Hoodie promises superior warmth with every wear.",
                    "inStock":true,
                    "categories":"Clothing>Men>Tops>Hoodies & Sweatshirts,Clothing>Collections>Eco Friendly",
                    "productImages":"http:\/\/eimages.valtim.com\/acme-images\/product\/m\/h\/mh01-black_main.jpg",
                    "price":52
                },
                {
                    "sku":"WB03-L-Green",
                    "type":"variation",
                    "name":"Celeste Sports Bra-L-Green",
                    "isPublished":true,
                    "shortDescription":"NULL",
                    "description":"Whatever your goals for the day's workout, the Celeste Sports Bra lets you do it in comfort and coolness, plus enhanced support and shaping.",
                    "inStock":true,
                    "categories":"Clothing>Women>Tops>Bras & Tanks,Clothing>Collections>Performance Fabrics",
                    "productImages":"http:\/\/eimages.valtim.com\/acme-images\/product\/w\/b\/wb03-green_main.jpg",
                    "price":39
                }
            ],
            "total": 3
        }
        """

    @search-products
    Scenario: Search products without filters
        Given There are products with the following details:
            | id   | sku           | type      | name                          | is_published | short_description | description                                                                                                                                                                            | in_stock | stock | categories                                                                | images                                                                | price |
            | 139  | MH09-L-Blue   | variation | Abominable Hoodie-L-Blue      | true         | NULL              | It took CoolTech weather apparel know-how and lots of wind-resistant fabric to get the Abominable Hoodie just right. Blue heather hoodie.                                       | true     | 100   | Clothing>Men>Tops>Hoodies & Sweatshirts                                   | http://eimages.valtim.com/acme-images/product/m/h/mh09-blue_main.jpg  | 69    |
            | 647  | MT07-L-Gray   | variation | Argus All-Weather Tank-L-Gray | true         | NULL              | The Argus All-Weather Tank is sure to become your favorite base layer or go-to cover for hot outdoor workouts.Dark gray polyester spandex tank.                                        | true     | 100   | Clothing>Men>Tops>Tanks,Clothing>Collections>Eco Friendly                 | http://eimages.valtim.com/acme-images/product/m/t/mt07-gray_main.jpg  | 22    |
            | 1585 | WB03-L-Green  | variation | Celeste Sports Bra-L-Green    | true         | NULL              | Whatever your goals for the day's workout, the Celeste Sports Bra lets you do it in comfort and coolness, plus enhanced support and shaping.                                           | true     | 100   | Clothing>Women>Tops>Bras & Tanks,Clothing>Collections>Performance Fabrics | http://eimages.valtim.com/acme-images/product/w/b/wb03-green_main.jpg | 39    |
            | 2    | MH01-XS-Black | variation | Chaz Kangeroo Hoodie-XS-Black | true         | NULL              | Ideal for cold-weather training or work outdoors, the Chaz Hoodie promises superior warmth with every wear.                                                                            | true     | 100   | Clothing>Men>Tops>Hoodies & Sweatshirts,Clothing>Collections>Eco Friendly | http://eimages.valtim.com/acme-images/product/m/h/mh01-black_main.jpg | 52    |
            | 1281 | WJ09-L-Blue   | variation | Jade Yoga Jacket-L-Blue       | true         | NULL              | If only all your other jackets were as comfortable as the relaxed-fit Jade Yoga Jacket, perfect for use during stretching, biking to and from studio or strolling on breezy fall days. | true     | 100   | Clothing>Women>Tops>Jackets,Clothing>Collections>Erin Recommends,Clothing | http://eimages.valtim.com/acme-images/product/w/j/wj09-blue_main.jpg  | 32    |
        When I send a POST request to "/products" with body:
        """
        {
            "filters": [],
            "orderBy": null,
            "order": null,
            "limit": 10,
            "offset": 0
        }
        """
        Then the response status code should be 200
        And the response content should have the following schema:
        """
        {
            "$schema":"https://json-schema.org/draft/2020-12/schema",
            "$id":"http://cqrs-ecommerce.com/products/search-by-criteria.json",
            "type":"object",
            "properties": {
                "hits": {
                    "type":"array",
                    "items":{
                        "type":"object",
                        "properties":{
                            "sku":{
                                "type":"string"
                            },
                            "type":{
                                "type":"string"
                            },
                            "name":{
                                "type":"string"
                            },
                            "isPublished":{
                                "type":"boolean"
                            },
                            "shortDescription":{
                                "type":[
                                    "string",
                                    "null"
                                ]
                            },
                            "description":{
                                "type":"string"
                            },
                            "inStock":{
                                "type":"boolean"
                            },
                            "categories":{
                                "type":"string"
                            },
                            "productImages":{
                                "type":"string"
                            },
                            "price":{
                                "type":"number"
                            }
                        },
                        "required":[
                            "sku",
                            "type",
                            "name",
                            "isPublished",
                            "shortDescription",
                            "description",
                            "inStock",
                            "categories",
                            "productImages",
                            "price"
                        ],
                        "additionalProperties":false
                    }
                },
                "total": {
                    "type": "number"
                }
            },
            "required":["hits","total"],
            "additionalProperties":false
        }
        """

