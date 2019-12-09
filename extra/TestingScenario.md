# Testing

Here you will find a little requests description.

## Postman request collection
[download](requests_collection.json) For testing you can use Postman's requests collection.
Don't forget to chance {{$id}} in some requests.


## Curl requests examples
### Create new product
```
curl --location --request POST 'http://localhost:8080/product' \
--header 'Content-Type: application/json' \
--data-raw '{
    "description": "Test product description",
    "name": "Image"
}'
```

### Update product
Important: in request you need to replace {{$id}} to needful product id.
```
curl --location --request PUT 'http://localhost:8080/product/24' \
--header 'Content-Type: application/json' \
--data-raw '{
    "description": "Test product description",
    "name": "Image"
}'
```

### Remove product
Important: in request you need to replace {{$id}} to needful product id.
```
curl --location --request DELETE 'http://localhost:8080/product/{{$id}}' \
--header 'Content-Type: application/json'
```

### Get product with id
Important: in request you need to replace {{$id}} to needful product id.
```
curl --location --request GET 'http://localhost:8080/product/{{$id}}'
```

### Get products list
```
curl --location --request GET 'http://localhost:8080/products'
```
