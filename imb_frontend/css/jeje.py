numero = int(input("Introduce un número: "))

suma_pares = 0
suma_impares = 0

for i in range(1, numero + 1):
    if i % 2 == 0:
        suma_pares += i
    else:
        suma_impares += i

print(f"Suma de los números pares: {suma_pares}")
print(f"Suma de los números impares: {suma_impares}")


# Código para pedir productos al usuario y almacenarlos en una lista sin duplicados
productos = set()
producto = ''
while producto.lower() != 'fin':
    producto = input("Introduce un producto (o escribe 'fin' para terminar): ")
    if producto.lower() != 'fin':
        productos.add(producto)

print("Lista de productos únicos:")  
print(list(productos))
