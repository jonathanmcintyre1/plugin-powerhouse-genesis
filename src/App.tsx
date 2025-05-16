
import { Toaster } from "@/components/ui/toaster";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { TooltipProvider } from "@/components/ui/tooltip";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Routes, Route } from "react-router-dom";
import Index from "./pages/Index";
import NotFound from "./pages/NotFound";

interface AppProps {
  settings?: {
    generalSettings?: any;
    textSettings?: any;
    keyboardSettings?: any;
    imageSettings?: any;
    jsSettings?: any;
    appearanceSettings?: any;
    messages?: any;
    advancedSettings?: any;
    ajaxUrl?: string;
    nonce?: string;
    pluginUrl?: string;
  };
}

const queryClient = new QueryClient();

const App = ({ settings = {} }: AppProps) => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter basename="/wp-admin/admin.php">
        <Routes>
          <Route path="/" element={<Index initialSettings={settings} />} />
          <Route path="page=copyprotect" element={<Index initialSettings={settings} />} />
          {/* ADD ALL CUSTOM ROUTES ABOVE THE CATCH-ALL "*" ROUTE */}
          <Route path="*" element={<NotFound />} />
        </Routes>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;
