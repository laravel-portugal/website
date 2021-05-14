import fetch from 'node-fetch'
import puppeteer from 'puppeteer-core'

// somehow, node is not resolving the IP from the hostname. ping on the shell, does..
// const response = await fetch('http://chromium-nextools/json/version')
// workaround: for now, use thhe direct container ip
const response = await fetch('http://172.18.0.13:9222/json/version')
const { webSocketDebuggerUrl } = await response.json()

const browser = await puppeteer.connect({ browserWSEndpoint: webSocketDebuggerUrl })
const page = await browser.newPage()

await page.goto('https://laravel.pt')
await page.screenshot({ path: 'example.png' })
await browser.close()
