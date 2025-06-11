# Motto WP STARTER PACK BOILERPLATE


## Deploy

*Please put here the most crucial things regarding the deploy phase.*

*Exmaple:*

🔐 **FTP/SFTP name in 1password:** Zenbox - FTP

🔄 **Auto deploy on master branch**

## Plugins

*Please update information about plugins which have big impact on some functionality.*

*Exmaple:*

- [GravityForms](https://docs.gravityforms.com/) - to handle forms

## Maintenance

*In case of maintenance plan please provide check list.*

*Exmaple:*

- DO NOT update XXXXX plugin.
- Check the XXXXX plugin.
- Perform action on XXXXXX.
- Check if main contact form is submitting succesfully.

---
---
# INTRODUCTION

## Run project:

Create new host with MAMP and run the server. Important! Name of the host have to be exactly the same as *YOUR-THEME-NAME*.

Go to your project in htdocs/*YOUR-HOST-NAME*/wp-content/themes/*YOUR-THEME-NAME*/ directory.

Run commands:
// Please use node version 16 or higher - to switch use nvm and type `$ nvm use 16`

```
$ npm i
$ npm run dev (development mode) / npm run dev-local (development with Local by Flywheel)
$ npm run build (build)

$ yarn dev (development mode)
$ yarn build (build)
```

```
composer require stoutlogic/acf-builder
```

1. In WordPress CMS Admin panel add new `All-in-One WP Migration` plugin, then upload `all-in-one-wp-migration-unlimited-extension.zip` from `wp-content/themes/*YOUR-THEME-NAME*/import-files`.

2. Go to http://wp-starter-pack.motto.co/wp-admin -> All-in-One -> Export -> Advanced options ->  Do not export themes (files) -> Export to file.

3. Go to your localhost -> Wp Admin -> All-in-One -> Import -> Import from file -> and import previously exported file.

4. Go to Wp Admin -> Appearance -> Themes and choose Theme by motto

5. Great you're ready to develop!

# Github automation with Cloudways

## 1. Configure Secret keys

1. Configure "Deployment via GIT" for all your branches
   https://support.cloudways.com/en/articles/5124087-deploy-code-to-your-application-using-git
   Your "Deployment Path" should look like this:

```
public_html/wp-content/themes/<THEME_NAME>-dist
```

2. In the Cloudways panel, in the lower left corner, go to the "API Integration" tab.

3. Generate the API code and copy it to the clipboard.

4. Go to the GitHub repository, open: Settings > Secrets and variables > Actions > Secrets. Add the copied API key:

```
Name: CLOUDWAYS_API_KEY
Secret: <YOUR_COPIED_API_KEY>
```

5. In the same tab add:

```
Name: CLOUDWAYS_EMAIL
Secret: <YOUR_CLOUDWAYS_ACCOUNT_EMAIL>
```

## 2. GitHub Actions Configuration

1. In the project repository, go to:

```
wp-content/themes/.github/workflows/cloudways.yml
```

2. Uncomment code

3. Check if the GitHub branches reflect your branches used in the project:

```
DEV_BRANCH: dev
LIVE_BRANCH: main
```

4. Change theme name to your name used in the project:

```
THEME_NAME: actions-test-dist
```

5. Open the Cloudways panel and fill in the variables:

```
#open your server tab and copy the number from the url
CLOUDWAYS_SERVER_ID: 1413064


#open your live application tab and copy the number from the url
CLOUDWAYS_LIVE_APP_ID: 5259884


#paste here your live application name
CLOUDWAYS_LIVE_APP_NAME: Motto-hosting


#open your staging application tab and copy the number from the url
CLOUDWAYS_STAGING_APP_ID: 5266970


#paste here your staging application name
CLOUDWAYS_STAGING_APP_NAME: Staging-Motto-hosting
```


# Github automation with WP Engine

## 1. Generating SSH keys

1. Open terminal on your computer.

2. Type the following command to generate a new SSH key:

```
cd ~/.ssh && ssh-keygen -t ed25519 -C wpengine-deploy
```

3. You will be asked to provide a filename to save the key, type **github_wpengine**:

```
Enter file in which to save the key (/Users/<user>/.ssh/id_ed25519): github_wpengine
```

4. Next You will be asked to provide an optional password - leave it blank.

5. Two files will be generated:

```
Macintosh HD/Users/<YOUR_USER>/.ssh/

github_wpengine – private key
github_wpengine.pub – public key
```


## 2. Adding a public key to WP Engine

1. Open [WP Engine > Profile > SSH keys](https://my.wpengine.com/profile/ssh_keys).

2. Click "Create SSH key".

3. Copy the contents of the github_wpengine.pub file:

```
cat ~/.ssh/github_wpengine.pub
```

4. Paste the contents into WP Engine and save.


## 3. Adding your private key to GitHub Secrets

1. Go to your GitHub repository.

2. Open Settings > Secrets and variables > Actions.

3. Click New repository secret.

4. Set the name: WPE_SSH_PRIVATE_KEY.

5. Copy the contents of the private key:

```
cat ~/.ssh/github_wpengine
```

6. Paste the contents into GitHub Secrets and save.


## 4. GitHub Actions Configuration

1. In the project repository, go to:

```
wp-content/themes/.github/workflows/wpengine.yml
```

2. Uncomment code

3. Check if the GitHub branches reflect your branches used in the project:

```
DEV_BRANCH: dev
LIVE_BRANCH: main
```

4. Open the WP Engine panel, copy the environment name and then paste it to variables:
```
WPE_ENV_DEV: mottotestdev
WPE_ENV_PROD: mottotest
```

5. Change theme name to your name used in the project:
```
THEME_NAME: actions-test-dist
```


# With this boilerplate you get:
- SCSS injection
- JS reloading
- PHP reloading
- JS linter
- SCSS linter with properties order
- JS minification
- CSS minification
- CSS versioning
- Images lazyload
- GSAP 3
- Swiper
- dist directory with all files you need in production
- GitHub autoupload with WP Engine
- GitHub autoupload with Cloudways


# Creating new blocks:

For creating new blocks, it's best to copy the existing block and change the old block name appearances for the new one accordingly.

1. Duplicate the old block folder in /parts/blocks/.

2. Change the names of the screenshot and styles files.

3. Change the names in the template and style files' code.

4. Add a JS file with the naming of block-name.js (may require stopping and running the `npm run dev` script again).

5. Add the necessary line in /inc/gutenberg.php file for the block to be seen in the editor.

## Creating new acf components:

For creating new component, it's best to copy the existing component and change the old component name appearances for the new one accordingly.

1. Duplicate the old component folder in /parts/acf-components/.

2. Change the names in the template and style files' code.

3. To easly insert the component use function `get_acf_component('component-name', [data])` or `get_acf_components(['component-name' => [data], 'component-name-2' => [data-2]])`.

## Shorthand functions:
To check all the shorthand functions used `get_template_part()` check file `inc/helpers/get-template-part-shorthand.php`.

## With this boilerplate you get:
- [GSAP 3](https://gsap.com/docs/v3/)
- [Swiper](https://swiperjs.com/swiper-api)
- And: SCSS injection, JS reloading, PHP reloading, JS linter, SCSS linter with properties order, JS minification, CSS minification, CSS versioning, Images lazyload, dist directory with all files you need in production

## Enjoy!

