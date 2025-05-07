import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';

export default [
  {
    input: 'Resources/Public/JavaScript/Core/preview.js',
    output: {
      file: 'Resources/Public/JavaScript/Bundle/preview.bundle.js',
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
    input: 'Resources/Public/JavaScript/Core/animation.js',
    output: {
      file: 'Resources/Public/JavaScript/Bundle/animation.bundle.js',
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
