FROM readytalk/nodejs
EXPOSE 3000
RUN ["bin/bash/","mkdir","custosales"]
ADD * /custosales
RUN ["/bin/bash","cd","custosales"]
RUN ["/bin/bash","npm","install"]
ENTRYPOINT ["/bin/bash","/custosales/npm","start"]
