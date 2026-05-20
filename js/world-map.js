/**
 * MoltHost — World map component (Alpine + jsvectormap)
 *
 * Registers a single Alpine component: `molthostWorldMap(markers)`.
 * Each marker is { name, coords:[lat,lng], city, country, status }.
 *
 * The world-map data ships as a side-effect script that calls
 * `jsVectorMap.addMap("world", ...)` on a global. Since we use ESM, we
 * expose the class globally before dynamically loading the world data,
 * and gate component init on a single shared Promise.
 */

import jsVectorMap from 'jsvectormap'
import 'jsvectormap/dist/jsvectormap.css'

if (typeof window !== 'undefined' && !window.jsVectorMap) {
    window.jsVectorMap = jsVectorMap
}

const worldReady = import('jsvectormap/dist/maps/world.js').catch(err => {
    console.warn('[molthost] world map data failed to load', err)
    throw err
})

function readCssVar (name, fallback) {
    if (typeof window === 'undefined') return fallback
    const value = getComputedStyle(document.documentElement).getPropertyValue(name).trim()
    return value || fallback
}

function buildPalette () {
    const primary = readCssVar('--c-primary', '10 82% 56%')
    const muted   = readCssVar('--c-muted',   '30 10% 45%')
    const bg      = readCssVar('--c-background-secondary', '22 12% 9%')
    const neutral = readCssVar('--c-neutral', '22 8% 22%')

    return {
        markerFill: `hsl(${primary})`,
        markerStroke: `hsl(${primary} / 0.35)`,
        regionFill: `hsl(${neutral} / 0.65)`,
        regionHover: `hsl(${primary} / 0.30)`,
        tooltipBg: `hsl(${bg})`,
        tooltipText: `hsl(${muted})`
    }
}

export function registerMolthostWorldMap (Alpine) {
    Alpine.data('molthostWorldMap', (markers = []) => ({
        instance: null,

        async init (canvas) {
            if (!canvas) return
            if (!markers || markers.length === 0) return

            try {
                await worldReady
            } catch (_) {
                return
            }

            const palette = buildPalette()

            try {
                this.instance = new jsVectorMap({
                    selector: canvas,
                    map: 'world',
                    backgroundColor: 'transparent',
                    zoomButtons: false,
                    zoomOnScroll: false,
                    draggable: false,
                    regionStyle: {
                        initial: {
                            fill: palette.regionFill,
                            stroke: 'transparent',
                            fillOpacity: 0.55
                        },
                        hover: {
                            fill: palette.regionHover,
                            fillOpacity: 0.85
                        }
                    },
                    markers: markers.map(m => ({
                        name: this._formatName(m),
                        coords: m.coords,
                        style: {
                            fill: m.status === 'active' ? palette.markerFill : palette.tooltipText
                        }
                    })),
                    markerStyle: {
                        initial: {
                            fill: palette.markerFill,
                            stroke: palette.markerStroke,
                            strokeWidth: 6,
                            r: 5
                        },
                        hover: {
                            cursor: 'pointer',
                            stroke: palette.markerFill,
                            strokeWidth: 8
                        }
                    }
                })
            } catch (err) {
                console.warn('[molthost] world map init failed', err)
            }
        },

        _formatName (m) {
            const city = m.city || ''
            const country = m.country || ''
            const status = m.status === 'active' ? '●' : '○'
            const where = [city, country].filter(Boolean).join(', ') || m.code || 'edge'
            const code = (m.code || '').toUpperCase()
            return code ? `${status}  ${code} — ${where}` : `${status}  ${where}`
        }
    }))
}
