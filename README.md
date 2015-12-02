LibreOnline-ownCloud
===================

This project built on top of [libreoffice online](https://github.com/libreoffice/online) and most of the work provided by [Collabora](https://www.collabora.com/) and its developers. https://www.collaboraoffice.com/try-collabora-cloudsuite/


The project still on the **development** stage but the current state is already satisfactory for the most of the fundamental needs but biggest handicap about the project is installing and using it might be trouble for the end-users. 

Supported file formats are .xls, .ppt, .odt, .doc, and .docx and more...

----------
How to install
--------------

- Build [libreoffice online](https://github.com/libreoffice/online) on your ownCloud server or PC.
- Run loolwsd.
- Clone this repo as 'libreonline' to your ownCloud applications folder.
- Move or symlink `loleaflet` folder to `./owncloud/apps/libreonline/`
- Edit `LOOLWSD_IP` in `./owncloud/apps/libreonline/templates/online.php` if you are planning to run loolwsd on different server.
- Go to ownCloud Apps and Activate Libreonline.

----------

### Known Issues

**Problem**: Can't open .odt files.  
**Solution**: Try to disable Documents app on your ownCloud.


### Demo
https://www.youtube.com/watch?v=An7D5i34xKM

### Contributing
You can use issues page for bugs and feature requests.

### Developers
Özcan Esen (@ozcanesen) - Faruk Uzun (@ofuzun)
