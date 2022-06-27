# Dzoganik_Erp Module

Magento 2 module for sending orders to ERP using RabbitMQ.
After successful sending, the order status is changed to "processing".
Every transmission attempt is logged to a database table.

## Consumer that sends order's data to ERP
dzoganik.erp.order.send
