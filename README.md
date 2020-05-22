[![Codacy Badge](https://api.codacy.com/project/badge/Grade/739d131f64d54ef1b925262a031b6a6a)](https://www.codacy.com/manual/Fr0x13/p5-daphp-oc?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Fr0x13/p5-daphp-oc&amp;utm_campaign=Badge_Grade)
# p5-daphp-oc

This project has been carried out with the aim of passing a diploma on the [OpenClassrooms.com](https://openclassrooms.com/) learning platform.

To install it you need to have [composer](https://getcomposer.org/) installed.

Then run

```shell
composer install
```

Restore the database whith the dump **sql/dump.sql**.

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
