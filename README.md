
## Introduction

This Elementor addon includes a bundled version of wharfkit (inside lib folder) made using this repo https://github.com/Wapaca/bundlewharf 

Its purpose is to demonstrate how a wharfkit addon for wordpress could be done, it's not meant to be a general purpose wharfkit addon for wordpress. Feel free to use it as a starting point for your own implementation.

## How to use

1. Drop the plugin inside wp-content/plugins of your wordpress installation
2. Go into Settings -> General to change AppName and Chain info.
3. Inside a page edition using elementor you will get access to two widgets: "Wordpress Wharfkit Login" and "Wordpress Wharfkit Transact"

## Wordpress Wharfkit Login

It displays a login button then once user signin, it displays its account name + a logout button. There are no specific settings appart from the one inside general.

## Wordpress Wharfkit Transact

It has two settings, Button label and Transaction data.

Transaction data contains all the actions you want to do inside the transaction, here is an example

```sh
[{
  account: 'eosio.token',
  name: 'transfer',
  authorization: %actor_permission%,
  data: {
      from: %actor_name%,
      to: 'we',
      quantity: '0.00000001 WAX',
      memo: 'wordpress wharfkit first action'
  }
},{
  account: 'eosio.token',
  name: 'transfer',
  authorization: %actor_permission%,
  data: {
      from: %actor_name%,
      to: 'we',
      quantity: '0.00000001 WAX',
      memo: 'wordpress wharfkit second action'
  }
}]
```
Notice %actor_name% and %actor_permission% placeholders which will be automatically replaced by the connected user account name and current permission.
