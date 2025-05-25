/**
 * Rollup configuration for GSAP content animations
 * Bundles preview and animation JavaScript modules
 */
import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';

export default [
  {
    input: 'JavaScript/Core/preview.js',
    output: {
      file: 'JavaScript/Bundle/preview.bundle.js',
      format: 'iife',
      name: 'contentAnimationsPreview',
      sourcemap: true,
      globals: {
        gsap: 'gsap'
      }
    },
    external: ['gsap'],
    plugins: [
      resolve({ browser: true }),
      commonjs()
    ]
  },
  {
    input: 'JavaScript/Core/animation.js',
    output: {
      file: 'JavaScript/Bundle/animation.bundle.js',
      format: 'iife',
      name: 'contentAnimations',
      sourcemap: true,
      globals: {
        gsap: 'gsap'
      }
    },
    external: ['gsap'],
    plugins: [
      resolve({ browser: true }),
      commonjs()
    ]
  }
];
