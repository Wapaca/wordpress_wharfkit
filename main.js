const { SessionKit, WebRenderer, WalletPluginCloudWallet, WalletPluginAnchor, WalletPluginWombat } = Wharfkit;

const webRenderer = new WebRenderer()
let sessionKit = null

function initSessionKit() {
  const wharfkit_apps = document.getElementsByClassName('wordpress-wharfkit-app');

  if(!wharfkit_apps.length)
    return false;

  let appname = wharfkit_apps[0].getAttribute('data-appname')
  let chain_id = wharfkit_apps[0].getAttribute('data-chain-id')
  let chain_url = wharfkit_apps[0].getAttribute('data-chain-url')

  if([appname, chain_id, chain_url].includes(null))
    return false;

  sessionKit = new SessionKit({
    appName: appname,
    chains: [
      {
        id: chain_id,
        url: chain_url,
      },
    ],
    ui: webRenderer,
    walletPlugins: [
      new WalletPluginCloudWallet(),
      new WalletPluginAnchor(),
      new WalletPluginWombat()
    ],
  })

  return true;
}

// Set a variable inside the window object
window.wharfkit_data = {
  session: null,
  actor_name: '',
  isLoggedIn: false,
};

window.wharfkit_checkLogin = async () => {
  const restored = await sessionKit.restore()

  if(restored === undefined)
    return null;

  window.wharfkit_data.session = restored;
  window.wharfkit_data.actor_name = window.wharfkit_data.session.actor.toString()
  window.wharfkit_data.isLoggedIn = true
}
window.wharfkit_login = async () => {
  const response = await sessionKit.login()
  window.wharfkit_data.session = response.session
  window.wharfkit_data.actor_name = window.wharfkit_data.session.actor.toString()
  window.wharfkit_data.isLoggedIn = true

  window.wharfkit_render()
}
window.wharfkit_logout = async() => {
  await sessionKit.logout(window.wharfkit_data.session);
  window.wharfkit_data.session = null
  window.wharfkit_data.actor_name = ''
  window.wharfkit_data.isLoggedIn = false

  window.wharfkit_render()
}

window.wharfkit_transact = async (actions) => {
  return await window.wharfkit_data.session.transact({ actions })
}


// Mini rendering function, feel free to update the plugin at your convenience if you want to use a proper framework.
window.wharfkit_render = () => {
  let wharfkit_apps = document.getElementsByClassName('wordpress-wharfkit-app');

  for(const wharfkit_app of wharfkit_apps) {
    // Update variables
    const var_divs = wharfkit_app.getElementsByClassName("wordpress-wharfkit-variable");

    for(const var_div of var_divs) {
      const var_name = var_div.getAttribute('data-var');

      if(var_name === null)
        continue;

      if(window.wharfkit_data[var_name] === undefined || window.wharfkit_data[var_name] === null)
        continue;

      var_div.innerHTML = window.wharfkit_data[var_name]
    }

    // Update conditional display
    const vif_divs = wharfkit_app.getElementsByClassName("wordpress-wharfkit-vif");

    for(const vif_div of vif_divs) {
      const var_name = vif_div.getAttribute('data-var')
      let var_value = vif_div.getAttribute('data-value')

      if(var_name === null || null === var_value)
        continue;

      const value_replace = {
        'null': null,
        'undefined': undefined,
        'true': true,
        'false': false
      }

      if(value_replace[var_value] !== undefined)
        var_value = value_replace[var_value]

      if(window.wharfkit_data[var_name] === var_value)
        vif_div.style.display = "block";
      else
        vif_div.style.display = "none";
    }
  }

}

document.addEventListener("DOMContentLoaded", async () => {
  if(!initSessionKit()) {
    console.error('Wordpress Wharfkit: Impossible to init session kit');
    return;
  }
  await window.wharfkit_checkLogin()
  window.wharfkit_render()
});