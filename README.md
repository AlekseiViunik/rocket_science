# Оглавление
- [Задание](#задание)
- [Что сделано](#что-сделано)
- [Используемый стек](#используемый-стек)
- [Пример](#пример)

## Задание
```
Тестовое задание для middle php
Разработать API backend на фреймворке Laravel. В качестве БД использовать MySQL, Postgresql.
Ожидаемое время выполнения 4 часа. Результат должен быть выложен на github

Требуемый функционал:
Необходимо реализовать “каталог товаров”. Товар: название, цена, количество. Свойства (опции) товара: название
Свойства товара должны быть произвольными т е заполняться в БД
Реализовать фильтрацию списка товаров с множественным выбором,
например GET /products?properties[свойство1][]=значение1_своства1&properties[свойство1][]=значение2_своства1&properties[свойство2][]=значение1_свойства2.
Нужен api GET метод получения списка товаров (“каталог товаров”) пагинированных по 40

!Уточнение - пояснение!

Необходимо  сделать фильтр товаров по опциям товаров, например, есть товары "настольный светильник", с опциями цвет плафона, цвет арматруы, бренд.
Нужно по опциям отфильтровать товары.
Также пример любой интернет магазин https://svetilniki.shop/catalog/lustri
```


## Что сделано
1. Добавлены модели: Product, Property, ProductPropertyValue.
2. Добавлены связи "один ко многим" между Product и ProductPropertyValue и между Property и ProductPropertyValue.
3. Реализована связь "многие ко многим" между Product и Property через таблицу ProductPropertyValue.
4. Добавлены миграции для создания таблиц: products, properties, product_property_values.
5. Создан сид для заполнения базы тестовыми данными с товарами, их свойствами и значениями свойств.
6. Создан контроллер ProductController для обработки запросов к API.
7. Реализован метод в контроллере для фильтрации товаров по их свойствам.
8. Добавлен API-маршрут для получения списка товаров с фильтрацией по свойствам.
9. Протестирован API через curl, проверена фильтрация товаров.
10. Кастомизирован ответ API, чтобы вернуть только нужные поля товаров и их свойств.

## Используемый стек
![PHP version](https://img.shields.io/badge/PHP-8.2-green) 
![Laravel version](https://img.shields.io/badge/Laravel-11-blue)
![PostgreSQL version](https://img.shields.io/badge/PostgreSQL-14-yellow)
![Ubuntu version](https://img.shields.io/badge/Ubuntu-22.04-red)

## Пример
Пример ГЕТ запроса:
```curl
curl --location --globoff 'http://127.0.0.1:8000/products?properties[%D0%91%D1%80%D0%B5%D0%BD%D0%B4][]=Baga&properties[%D0%A6%D0%B2%D0%B5%D1%82][]=%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D1%8B%D0%B9'
```
Ответ:
```json
{
    "products": [
        {
            "id": 91,
            "name": "Напольная лампа",
            "price": "8600.00",
            "quantity": 8,
            "properties": [
                {
                    "property_name": "Цвет",
                    "value": "Красный"
                },
                {
                    "property_name": "Бренд",
                    "value": "Baga"
                },
                {
                    "property_name": "Размер",
                    "value": "Небольшой"
                }
            ]
        },
        {
            "id": 71,
            "name": "Настольная лампа",
            "price": "1800.00",
            "quantity": 5,
            "properties": [
                {
                    "property_name": "Цвет",
                    "value": "Красный"
                },
                {
                    "property_name": "Бренд",
                    "value": "Baga"
                },
                {
                    "property_name": "Размер",
                    "value": "Небольшой"
                }
            ]
        },
        {
            "id": 33,
            "name": "Настольная лампа",
            "price": "6800.00",
            "quantity": 1,
            "properties": [
                {
                    "property_name": "Цвет",
                    "value": "Красный"
                },
                {
                    "property_name": "Бренд",
                    "value": "Baga"
                },
                {
                    "property_name": "Размер",
                    "value": "Небольшой"
                }
            ]
        },
        {
            "id": 1,
            "name": "Люстра",
            "price": "3800.00",
            "quantity": 2,
            "properties": [
                {
                    "property_name": "Цвет",
                    "value": "Красный"
                },
                {
                    "property_name": "Бренд",
                    "value": "Baga"
                },
                {
                    "property_name": "Размер",
                    "value": "Небольшой"
                }
            ]
        },
        {
            "id": 5,
            "name": "Люстра",
            "price": "4800.00",
            "quantity": 5,
            "properties": [
                {
                    "property_name": "Цвет",
                    "value": "Красный"
                },
                {
                    "property_name": "Бренд",
                    "value": "Baga"
                },
                {
                    "property_name": "Размер",
                    "value": "Небольшой"
                }
            ]
        },
        {
            "id": 26,
            "name": "Напольная лампа",
            "price": "6000.00",
            "quantity": 7,
            "properties": [
                {
                    "property_name": "Цвет",
                    "value": "Красный"
                },
                {
                    "property_name": "Бренд",
                    "value": "Baga"
                },
                {
                    "property_name": "Размер",
                    "value": "Средний"
                }
            ]
        }
    ],
    "total": 6,
    "per_page": 40,
    "current_page": 1,
    "last_page": 1,
    "first_page_url": "http://127.0.0.1:8000/products?page=1",
    "last_page_url": "http://127.0.0.1:8000/products?page=1",
    "next_page_url": null,
    "prev_page_url": null
```
