[![Codacy Badge](https://app.codacy.com/project/badge/Grade/d51b4467bb4d41a3ad7a934aeb343a99)](https://www.codacy.com/gh/lchastanet/p5-daphp-oc/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=lchastanet/p5-daphp-oc&amp;utm_campaign=Badge_Grade)
# p5-daphp-oc

This project has been carried out with the aim of passing a diploma on the [OpenClassrooms.com](https://openclassrooms.com/) learning platform.

To install it you need to have [composer](https://getcomposer.org/) installed.

Then run

```shell
composer install
```

Restore the database whith the dump **sql/db.sql**.

To run app you need to put correct informations in **Config/config-sample.yml** file:

```yaml
# basePath is used if the site is hosted in a subfolder
basePath: #/p5-daphp-oc

#siteURL is the domain name where the site is hosteds
siteURL: #http://localhost

# mailer is the credentials to smtp serve use to send mails
mailer:
  smtpServerAdresse: #smtp.exemple.com
  smtpServerPort: #587
  mailAdresse: #user@domain.ext
  mailPassword: #azerty

# dataBase is the credentials to connect to dababase
dataBase:
  hostName: #localhost
  dbName: #frameworkOCauth
  login: #root
  password: #root
```

 then rename **config-sample.yml** in **config.yml**.
