
import { defineConfig } from "vite";
import react from "@vitejs/plugin-react-swc";
import path from "path";
import { componentTagger } from "lovable-tagger";

// https://vitejs.dev/config/
export default defineConfig(({ mode }) => ({
  server: {
    host: "::",
    port: 8080,
  },
  plugins: [
    react(),
    mode === 'development' && componentTagger(),
  ].filter(Boolean),
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./src"),
    },
  },
  build: {
    // Generate sourcemaps for better debugging
    sourcemap: true,
    // Ensure all assets have proper paths for WordPress admin context
    assetsDir: 'assets',
    // Change the output directory for the build
    outDir: 'dist',
    // Don't minify for easier debugging (optional, remove in production)
    minify: mode !== 'development',
    // Make sure CSS and JS are properly loaded
    cssCodeSplit: false,
    rollupOptions: {
      output: {
        // Ensure assets use relative paths
        assetFileNames: 'assets/[name].[ext]',
        chunkFileNames: 'assets/[name].js',
        entryFileNames: 'assets/[name].js',
        manualChunks: undefined, // Don't split into chunks for WordPress
      },
    },
  },
}));
