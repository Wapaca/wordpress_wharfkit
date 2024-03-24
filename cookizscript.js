const { SessionKit, WebRenderer, WalletPluginCloudWallet, WalletPluginAnchor, WalletPluginWombat } = Wharfkit;

const webRenderer = new WebRenderer()
const sessionKit = new SessionKit({
  appName: "testwharfkitwordpress",
  chains: [
    {
      id: "1064487b3cd1a897ce03ae5b6a865651747e2e152090f99c1d19d44e01aea5a4",
      url: "https://wax.greymass.com",
    },
  ],
  ui: webRenderer,
  walletPlugins: [
    new WalletPluginCloudWallet(),
    new WalletPluginAnchor(),
    new WalletPluginWombat()
  ],
})

window.wharfkit_session = null;

window.wharfkit_checkLogin = async () => {
  const restored = await sessionKit.restore()
  if(restored === undefined)
    return null;

  window.wharfkit_session = restored;
}
window.wharfkit_login = async () => {
  const response = await sessionKit.login()
  window.wharfkit_session = response.session
}
window.wharfkit_logout = async() => {
  await sessionKit.logout(this.session);
  window.wharfkit_session = null
}
window.wharfkit_transact = async (actions) => {
  return await window.wharfkit_session.transact({ actions })
}

document.addEventListener("DOMContentLoaded", () => {
  window.wharfkit_checkLogin()
});