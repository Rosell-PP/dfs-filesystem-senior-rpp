FROM node:20  

# Establecer el directorio de trabajo
WORKDIR /app

# Copiar package.json y package-lock.json
COPY package*.json ./  

# Instalar las dependencias de la aplicación
RUN yarn install

# Copiar el resto del código de la aplicación
COPY . .  

# Construir la aplicación  
RUN yarn build  

# Exponer el puerto en que se ejecutará la aplicación (ajusta el puerto si es necesario)
EXPOSE 3000

# Configurar el comando para iniciar la aplicación  
# CMD ["yarn", "serve"]