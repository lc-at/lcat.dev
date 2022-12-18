FROM python:3.7.3

RUN mkdir /lkat 

WORKDIR /lkat

COPY . /lkat

RUN chown daemon /lkat
RUN chmod 705 /lkat 
RUN pip install -r requirements.txt
ENV DOCKER_DEPLOY=True

EXPOSE 7211
USER daemon
CMD ["sh", "./startup.sh"]