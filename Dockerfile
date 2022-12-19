FROM python:3.7.3

RUN mkdir /lcat 

WORKDIR /lcat

COPY . /lcat
COPY config.py.template /lcat/config.py

RUN chown daemon /lcat
RUN chmod 705 /lcat 
RUN pip install -r requirements.txt
ENV DOCKER_DEPLOY=True

EXPOSE 7211
USER daemon
CMD ["sh", "./startup.sh"]