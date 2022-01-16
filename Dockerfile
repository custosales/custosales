FROM readytalk/nodejs
EXPOSE 3000
ADD * /
RUN ["/bin/bash","tar","xzf","custosales-0.0.10.tgz"]
RUN ["/bin/bash","cd",custosales"]
RUN ["/bin/bash","npm","install"]
ENTRYPOINT ['/custosales/npm','start']
