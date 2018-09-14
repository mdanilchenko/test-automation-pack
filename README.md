# Behat, Mink, Selenium Test automation Starter Pack

A self-contained Docker image to run Behat with no external dependencies.

This image is based on [Docksal/Behat](http://docksal.io) project.

Features:

- PHP7, Composer
- Behat 3.x
- DrupalExtension 3.x


### Usage

To run Behat tests that require a real browser (e.g. for JavaScript support) a headless Selenium Chrome/Firefox can be used.

There is a Docker Compose configuration, that will get you up and running with a Selenium Chrome.

```
docker-compose up -d
./run-behat --suite=core
```

In this case, you get two containers - one running a built-in PHP server for access to HTML reports and one running Selenium.
Behat runs within the first container and talks to the Selenium container to run tests with a real browser (Chrome/Firefox).

### Switching between Chrome and Firefox

1. Uncomment a respective line in `docker-compose.yml`:

    ```
    # Pick/uncomment one
    image: selenium/standalone-chrome
    #image: selenium/standalone-firefox
    ```

2. Update container configuration

    ```
    docker-compose up -d
    ```

3. Update `behat.yml` as necessary
    Chrome
    ```
    browser_name: chrome
    selenium2:
      wd_host: http://browser:4444/wd/hub
      capabilities: { "browser": "chrome", "version": "*" }
    ```

    Firefox
    ```
    browser_name: firefox
    selenium2:
      wd_host: http://browser:4444/wd/hub
      capabilities: { "browser": "firefox", "version": "*" }
    ```

4. Run tests


### HTML report

HTML report will be generated into the `html_report` folder.  
It can be accessed by navigating to `http://<your-docker-host-ip>:8000/html_report/` in your browser.  
Replace `<your-docker-host-ip>` as necessary (e.g. `localhost`).

### JUnit report

HTML report will be generated into the `html_report/junit/<suite-name>.xml` file.  
It can be accessed by navigating to `http://<your-docker-host-ip>:8000/html_report/html_report/junit/<suite-name>.xml` in your browser.  
Replace `<your-docker-host-ip>` as necessary (e.g. `localhost`).

### Screenshots

Screenshots are generated for each failed scenario and saved into the `html_report/screenshots/` folder.

## Debugging

The following command will start a bash session in the container.

```
docker run --rm -v $(pwd):/src -it --entrypoint=bash docksal/behat
```
