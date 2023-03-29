# Discount application

This application returns applied discounts for submitted orders.

## Infrastructure

Run the application services using Docker. Start the Docker services using:
```
docker-compose up
```

## Setup application

To setup the application locally (install composer packages etc...), run:
```
sh install.sh
```

## Run code quality checks

To run the code quality checks, run:
```
sh checks.sh
```

## Discount creation

Each discount definition can be created from reusable conditions and effects.
By mix-and-matching the conditions you can define when a discount can be applied to an order, and with the effect you can choose what discount amount gets applied to the order.

The three example discount definitions are added in `app/services.php`

## Validate requests

For ease of use, a Postman collection has been added that can be imported and used to validate the requests manually.
The import file is found in `.postman/discounts.postman_collection.json`

Additionally, the integration test in `tests/Integration/DiscountTest.php` automatically validates the provided example orders.
