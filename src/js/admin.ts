import '../css/wp-link-social-admin.scss'

type LinkNode = {
  title: string
  icon: string
  key: string
  url: string
}

type SupportedNetwork = {
  key: string
  title: string
  icon: string
}

declare const wpData: {
  nonce: string
  supportedNetworks: Record<string, SupportedNetwork>
  links: LinkNode[]
}

const { nonce, supportedNetworks } = wpData
let { links } = wpData

const $ = jQuery
const apiUrl = '/wp-json/wp-link-social/v1/social-links'
const htmlList = $('#wp-link-social-current')

function refreshSortUl() {
  htmlList.sortable('refresh')
}

function getLinksFromList() {
  const arr: LinkNode[] = []

  $('#wp-link-social-current > div').each((index, element) => {
    const key = element.dataset.key
    const url = element.dataset.url
    if (!key || !url) {
      return
    }
    arr.push({
      ...supportedNetworks[key],
      url,
    })
  })

  return arr
}

function updateHTML() {
  htmlList.empty()

  if (links.length === 0) {
    htmlList.append('<p>There are currently no links.</p>')
    refreshSortUl()
    return
  }

  links.forEach((link) => {
    const div = document.createElement('div')
    div.dataset.key = link.key
    div.dataset.url = link.url

    const iconDiv = document.createElement('div')
    const icon = document.createElement('span')
    $(icon).addClass(supportedNetworks[link.key].icon)
    iconDiv.append(icon)

    const button = document.createElement('button')
    const buttonIcon = document.createElement('span')
    $(buttonIcon).addClass('dashicons dashicons-no')
    button.append(buttonIcon)

    const content = document.createElement('a')
    $(content).attr('href', link.url)
    $(content).attr('target', '_blank')
    $(content).text(link.url)

    div.append(iconDiv)
    div.append(content)
    div.append(button)
    htmlList.append(div)
  })
  refreshSortUl()
}

async function updateLinks() {
  try {
    const method = 'POST'
    const response = await fetch(apiUrl, {
      method,
      body: JSON.stringify({ links }),
      headers: {
        'Content-Type': 'application/json',
        'X-WP-Nonce': nonce,
      },
    })

    if (!response.ok) {
      throw new Error(
        `Request to ${apiUrl} failed with status ${response.status} ${response.status}`
      )
    }
  } catch (error: any) {
    throw error
  }
}

function handleAddLink() {
  const key = $('#wp-link-social-network').val() as string
  const url = $('#wp-link-social-url').val() as string

  if (!key || !url) {
    alert('Please enter a network and url')
    return
  }

  const existing = links.find((link) => link.key === key)

  if (existing) {
    existing.url = url
    updateLinks()
    updateHTML()
    return
  }

  const newLink: LinkNode = {
    ...supportedNetworks[key],
    url,
  }

  links.push(newLink)
  updateLinks()
  updateHTML()
}

function handleUpdatedSort() {
  links = getLinksFromList()
  updateLinks()
}

async function handleRemoveLink(e: JQuery.ClickEvent) {
  const key = $(e.target).closest('div').data('key') as string
  links = links.filter((link) => link.key !== key)
  updateLinks()
  updateHTML()
}

$(window).on('load', () => {
  htmlList.sortable({
    update: handleUpdatedSort,
  } as any)

  $('#wp-link-social-add').on('click', handleAddLink)
  $('#wp-link-social-current').on('click', 'button', handleRemoveLink)
})
