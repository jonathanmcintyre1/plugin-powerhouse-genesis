
import React from 'react';
import SwitchGroup from '../ui/switch-group';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { FileText, ShoppingCart, Tag } from 'lucide-react';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';

interface AdvancedRulesProps {
  settings: {
    enablePerPostType: boolean;
    applyToBlogPosts: boolean;
    applyToPages: boolean;
    applyToProducts: boolean;
    disableForCategories: boolean;
  };
  updateSettings: (key: string, value: boolean) => void;
}

const AdvancedRules: React.FC<AdvancedRulesProps> = ({ settings, updateSettings }) => {
  return (
    <div className="space-y-6">
      <Card>
        <CardHeader>
          <CardTitle>Granular Content Control</CardTitle>
          <CardDescription>
            Apply different protection settings per content type
          </CardDescription>
        </CardHeader>
        <CardContent className="space-y-4">
          <SwitchGroup
            id="enable-per-post-type"
            label="Enable per Post/Page/Custom Post Type"
            description="Set specific protection rules for different content types"
            checked={settings.enablePerPostType}
            onCheckedChange={(checked) => updateSettings('enablePerPostType', checked)}
          />
        </CardContent>
      </Card>

      {settings.enablePerPostType && (
        <Tabs defaultValue="posts" className="w-full">
          <TabsList className="grid w-full grid-cols-3">
            <TabsTrigger value="posts" className="flex items-center space-x-2">
              <FileText className="h-4 w-4" />
              <span>Blog Posts</span>
            </TabsTrigger>
            <TabsTrigger value="pages" className="flex items-center space-x-2">
              <FileText className="h-4 w-4" />
              <span>Pages</span>
            </TabsTrigger>
            <TabsTrigger value="products" className="flex items-center space-x-2">
              <ShoppingCart className="h-4 w-4" />
              <span>Products</span>
            </TabsTrigger>
          </TabsList>
          
          <TabsContent value="posts" className="mt-4">
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center">
                  <FileText className="h-5 w-5 text-purple-600 mr-2" />
                  Blog Posts Protection
                </CardTitle>
                <CardDescription>
                  Configure protection settings specifically for blog posts
                </CardDescription>
              </CardHeader>
              <CardContent className="space-y-4">
                <SwitchGroup
                  id="apply-to-blog-posts"
                  label="Apply Protection to Blog Posts"
                  description="Enable all protection features for blog post content"
                  checked={settings.applyToBlogPosts}
                  onCheckedChange={(checked) => updateSettings('applyToBlogPosts', checked)}
                />
                
                <SwitchGroup
                  id="disable-for-categories"
                  label="Disable protection on specific categories/tags"
                  description="Exclude certain categories from content protection"
                  checked={settings.disableForCategories}
                  onCheckedChange={(checked) => updateSettings('disableForCategories', checked)}
                  disabled={!settings.applyToBlogPosts}
                />
                
                {settings.disableForCategories && settings.applyToBlogPosts && (
                  <div className="ml-6 mt-2 p-4 border border-gray-200 rounded-md bg-gray-50">
                    <p className="text-sm text-gray-500 mb-2">Select categories to exclude:</p>
                    <div className="space-y-2">
                      {['News', 'Tutorials', 'Announcements'].map((category) => (
                        <div key={category} className="flex items-center">
                          <input 
                            type="checkbox" 
                            id={`cat-${category}`} 
                            className="h-4 w-4 rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                          />
                          <label htmlFor={`cat-${category}`} className="ml-2 text-sm text-gray-700">
                            {category}
                          </label>
                        </div>
                      ))}
                    </div>
                  </div>
                )}
              </CardContent>
            </Card>
          </TabsContent>
          
          <TabsContent value="pages" className="mt-4">
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center">
                  <FileText className="h-5 w-5 text-purple-600 mr-2" />
                  Pages Protection
                </CardTitle>
                <CardDescription>
                  Configure protection settings specifically for WordPress pages
                </CardDescription>
              </CardHeader>
              <CardContent>
                <SwitchGroup
                  id="apply-to-pages"
                  label="Apply Protection to Pages"
                  description="Enable all protection features for page content"
                  checked={settings.applyToPages}
                  onCheckedChange={(checked) => updateSettings('applyToPages', checked)}
                />
              </CardContent>
            </Card>
          </TabsContent>
          
          <TabsContent value="products" className="mt-4">
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center">
                  <ShoppingCart className="h-5 w-5 text-purple-600 mr-2" />
                  WooCommerce Products
                </CardTitle>
                <CardDescription>
                  Configure protection settings specifically for WooCommerce products
                </CardDescription>
              </CardHeader>
              <CardContent>
                <SwitchGroup
                  id="apply-to-products"
                  label="Apply Protection to Product Descriptions"
                  description="Enable protection for WooCommerce product descriptions"
                  checked={settings.applyToProducts}
                  onCheckedChange={(checked) => updateSettings('applyToProducts', checked)}
                />
              </CardContent>
            </Card>
          </TabsContent>
        </Tabs>
      )}
    </div>
  );
};

export default AdvancedRules;
